<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // IMPORTANT : utilisateur NON vérifié
            $user->setIsVerified(false);

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoi de l'email de confirmation
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@tonsite.com', 'Ton Site'))
                    ->to($user->getEmail())
                    ->subject('Confirme ton adresse email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            $this->addFlash(
                'success',
                'Un email de confirmation vous a été envoyé.'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
    
        $id = $request->query->get('id'); 
    
        if (!$id) {
            $this->addFlash('verify_email_error', 'Lien de confirmation incomplet (id manquant).');
            return $this->redirectToRoute('app_login');
        }
    
        $user = $userRepository->find($id);
        if (!$user) {
            $this->addFlash('verify_email_error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_login');
        }
    
        try {
            $this->emailVerifier->handleEmailConfirmation(
                $request,
                (string) $user->getId(),
                (string) $user->getEmail()
            );
        } catch (\Exception $e) {
            $this->addFlash('verify_email_error', 'Le lien de confirmation est invalide ou expiré.');
            return $this->redirectToRoute('app_login');
        }
    
        $user->setIsVerified(true);
        $entityManager->flush();
    
        $this->addFlash('success', 'Votre adresse email a bien été vérifiée.');
        return $this->redirectToRoute('app_login');
    }
    
}

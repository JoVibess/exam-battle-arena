<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer
    ) {}

    public function sendEmailConfirmation(
        string $verifyEmailRouteName,
        User $user,
        TemplatedEmail $email
    ): void {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $email->context([
            'signedUrl' => $signatureComponents->getSignedUrl(),
            'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
            'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
        ]);

        $this->mailer->send($email);
    }

    public function handleEmailConfirmation(
        Request $request,
        string $userId,
        string $userEmail
    ): void {
        $this->verifyEmailHelper->validateEmailConfirmation(
            $request->getUri(),
            $userId,
            $userEmail
        );
    }

    public function sendEmail(TemplatedEmail $email): void
    {
        $this->mailer->send($email);
    }
}


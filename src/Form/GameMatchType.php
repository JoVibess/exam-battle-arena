<?php

namespace App\Form;

use App\Entity\GameMatch;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameMatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('playerOne', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Joueur 1',
            ])
            ->add('playerTwo', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Joueur 2',
            ])
            ->add('round', IntegerType::class, [
                'label' => 'Round',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameMatch::class,
        ]);
    }
}

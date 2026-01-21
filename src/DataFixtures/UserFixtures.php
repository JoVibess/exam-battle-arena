<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Admin
        $admin = new User();
        $admin->setEmail('admin@battle.test');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $admin->setIsVerified(true);
        $manager->persist($admin);

        $this->addReference('admin', $admin);

        // Joueurs
        for ($i = 1; $i <= 8; $i++) {
            $user = new User();
            $user->setEmail("player$i@battle.test");
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            $user->setIsVerified(true);
            $manager->persist($user);

            $this->addReference("player_$i", $user);
        }

        $manager->flush();
    }
}

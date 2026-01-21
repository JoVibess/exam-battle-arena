<?php

namespace App\DataFixtures;

use App\Entity\GameMatch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GameMatchFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $match = new GameMatch();
            $match->setPlayerOne($this->getReference("player_" . (($i * 2) - 1), \App\Entity\User::class));
            $match->setPlayerTwo($this->getReference("player_" . ($i * 2), \App\Entity\User::class));
            $match->setRound(1);
            $match->setStatus('scheduled');

            $manager->persist($match);
            $this->addReference("match_$i", $match);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

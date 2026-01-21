<?php

namespace App\DataFixtures;

use App\Entity\MatchResult;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MatchResultFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Match 1 : accord
        $r1 = new MatchResult();
        $r1->setGameMatch($this->getReference('match_1', \App\Entity\GameMatch::class));
        $r1->setPlayer($this->getReference('player_1', \App\Entity\User::class));
        $r1->setResult('WIN');
        $manager->persist($r1);

        $r2 = new MatchResult();
        $r2->setGameMatch($this->getReference('match_1', \App\Entity\GameMatch::class));
        $r2->setPlayer($this->getReference('player_2', \App\Entity\User::class));
        $r2->setResult('LOSS');
        $manager->persist($r2);

        // Match 2 : conflit
        $r3 = new MatchResult();
        $r3->setGameMatch($this->getReference('match_2', \App\Entity\GameMatch::class));
        $r3->setPlayer($this->getReference('player_3', \App\Entity\User::class));
        $r3->setResult('WIN');
        $manager->persist($r3);

        $r4 = new MatchResult();
        $r4->setGameMatch($this->getReference('match_2', \App\Entity\GameMatch::class));
        $r4->setPlayer($this->getReference('player_4', \App\Entity\User::class));
        $r4->setResult('WIN');
        $manager->persist($r4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            GameMatchFixtures::class,
        ];
    }
}

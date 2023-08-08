<?php

namespace App\DataFixtures;

use App\Entity\MyClasses;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MyClassesFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function loadData(): void
    {
        $this->createMany(10, 'my_classes', function (int $i) {
            $myClasses = new MyClasses();
            $dances = $this->getRandomReference('dances');
            $users = $this->getRandomReference('users');
            $myClasses->setDance($dances);
            $myClasses->setAuthor($users);

            $this->manager->persist($myClasses);

            return $myClasses;
        });

        $this->manager->flush();
    }

    public function getDependencies(): array
    {
        return [DanceFixtures::class, UserFixtures::class];
    }
}
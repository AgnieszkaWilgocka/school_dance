<?php

namespace App\DataFixtures;

//use AbstractBaseFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Dance;

class DanceFixtures extends AbstractBaseFixtures
{
   public function loadData(): void
   {
       $this->createMany(10, 'dances', function(int $i) {
           $dance = new Dance();
           $dance->setName($this->faker->colorName());
           $dance->setField(20);
           $this->manager->persist($dance);

           return $dance;
       });
       $this->manager->flush();
   }
}

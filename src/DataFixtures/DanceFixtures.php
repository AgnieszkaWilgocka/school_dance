<?php

namespace App\DataFixtures;

//use AbstractBaseFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Dance;

class DanceFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
   public function loadData(): void
   {
       $this->createMany(10, 'dances', function(int $i) {
           $dance = new Dance();
           $dance->setName($this->faker->colorName());
           $dance->setField(20);
           $tags = $this->getRandomReferences(
               'tags',
               $this->faker->numberBetween(1, 2)
           );

           foreach($tags as $tag) {
               $dance->addTag($tag);
           }

           $this->manager->persist($dance);

           return $dance;
       });
       $this->manager->flush();
   }

   public function getDependencies(): array
   {
       return [TagFixtures::class];
   }
}

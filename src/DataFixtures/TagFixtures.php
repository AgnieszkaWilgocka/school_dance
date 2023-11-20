<?php
namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class TagFixtures extends AbstractBaseFixtures
{
    public function loadData(): void
    {
        $this->createMany(10, 'tags', function (int $i) {
            $tag = new Tag();
            $tag->setTitle($this->faker->colorName());
            $tag->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $tag->setUpdatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $this->manager->persist($tag);

            return $tag;
        }
        );
        $this->manager->flush();
    }
}
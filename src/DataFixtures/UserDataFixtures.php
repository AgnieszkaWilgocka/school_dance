<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractBaseFixtures;
use App\Entity\UserData;

class UserDataFixtures extends AbstractBaseFixtures
{
    public function loadData(): void
    {
        $this->createMany(5, 'usersData', function(int $i) {
            $userData = new UserData();
            $userData->setNick($this->faker->city());

            return $userData;
        });

        $this->createMany(5, 'adminUsersData', function (int $i) {
            $userData = new UserData();
            $userData->setNick($this->faker->city);

            return $userData;
        });

        $this->manager->flush();
    }
}

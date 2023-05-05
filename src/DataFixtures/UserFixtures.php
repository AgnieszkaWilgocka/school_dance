<?php

namespace App\DataFixtures;

use App\Entity\Enum\UserRole;
use App\Entity\User;
use App\Entity\UserData;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use App\DataFixtures\AbstractBaseFixtures;

class UserFixtures extends AbstractBaseFixtures
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(5, 'users', function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('user%d@example.com', $i));
            $user->setRoles([UserRole::ROLE_USER->value]);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'user1234'
                )
            );
            $user->setUserData($this->getReference('usersData_' . $i));

            return $user;
        });

        $this->createMany(5, 'admins', function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@example.com', $i));
            $user->setRoles([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value]);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'admin1234'
                )
            );

            $user->setUserData($this->getReference('adminUsersData_' . $i));
            return $user;
        });

        $this->manager->flush();
    }

    /**
     * Get Dependencies
     *
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [UserDataFixtures::class];
    }
}

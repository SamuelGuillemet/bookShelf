<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{

    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    private function getUserData()
    {
        yield [
            'sam@localhost',
            'sam',
            'ROLE_USER'
        ];
        yield [
            'admin@localhost',
            'admin',
            'ROLE_ADMIN'
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$email, $plainPassword, $role]) {
            $user = new User();
            $encodedPassword = $this->userPasswordHasherInterface->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
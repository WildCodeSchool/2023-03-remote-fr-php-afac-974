<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@afac.com');
        $admin->setFirstname('Thomas');
        $admin->setLastname('Dupont');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $admin->setAvatar('https://img.freepik.com/vecteurs-premium/conception-avatar-personne_24877-38137.jpg?w=2000');
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@afac.com');
        $user->setFirstname('Camille');
        $user->setLastname('Dubois');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'userpassword'
        );
        $user->setPassword($hashedPassword);
        $user->setAvatar('https://img.freepik.com/premium-vector/person-avatar-design_24877-38130.jpg?w=2000');
        $manager->persist($user);

        $manager->flush();
    }
}

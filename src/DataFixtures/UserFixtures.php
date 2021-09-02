<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->encoder = $userPasswordHasher;
    }
    public function load(ObjectManager $manager)
    {
        // $users =
        // [
        //     [
        //         'firstName'=>'Malick',
        //         'lastname'=>'Tounkara',
        //     ]
        // ];
        $user = new User();
        $user->setEmail('admin@malick-tounkara.com');
        $user->setPassword($this->encoder->hashPassword($user,'demarrer'));
        $user->setRoles(['ROLE_ADMIN']);
        $personne = new Personne();
        $personne->setFirstName('Malick')->setLastName('Tounkara');
        $user->setPersonne($personne);

        $manager->persist($user);

        $manager->flush();
    }
}

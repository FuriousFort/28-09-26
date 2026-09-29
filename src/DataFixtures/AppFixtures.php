<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            [
                'email' => 'alice@example.fr',
                'firstName' => null,
                'lastName' => null,
                'createdAt' => new \DateTimeImmutable(),
            ],
            [
                'email' => 'bob@example.fr',
                'firstName' => null,
                'lastName' => null,
                'createdAt' => new \DateTimeImmutable(),
            ],
            [
                'email' => 'camille.aubert@example.fr',
                'firstName' => 'Camille',
                'lastName' => 'Aubert',
                'createdAt' => new \DateTimeImmutable('2026-02-04'),
            ],
        ];

        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            
            if ($data['firstName'] !== null) {
                $user->setFirstName($data['firstName']);
            }
            if ($data['lastName'] !== null) {
                $user->setLastName($data['lastName']);
            }
            
            $user->setCreatedAt($data['createdAt']);

            // Hachage du mot de passe partagé
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'motdepasse');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
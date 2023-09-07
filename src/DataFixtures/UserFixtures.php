<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\CountryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    protected UserPasswordHasherInterface $hasher;
    protected $countryRepository;
    public function __construct(UserPasswordHasherInterface $hasher, CountryRepository $countryRepository)
    {
        $this->hasher = $hasher;
        $this->countryRepository = $countryRepository;
    }
    public function load(ObjectManager $manager)
    {
        $countries = $this->countryRepository->findAll();

        for ($i = 0; $i < 4; ++$i) {
            $user = new User();
            $user->setEmail("user" . $i . "@example.com");
            $password = $this->hasher->hashPassword($user, "aze123");
            $user->setPassword($password);
            $user->setName("user" . $i);
            $user->setAge(mt_rand(18, 80));
            if (0 == $i % 2) {
                $user->setIsadmin(true);
            } else {
                $user->setIsadmin(false); // mettre le else sinon il ressort pas du if ... ? 
            }
            $user->setImage("image" . $i);
            $randomNumberOfCountry = mt_rand(0, count($countries) - 1);
            $user->setCountry($countries[$randomNumberOfCountry]);
            $manager->persist($user);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CountryFixtures::class,
        ];
    }

}
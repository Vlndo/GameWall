<?php

namespace App\DataFixtures;

use App\Entity\Bill;
use App\Repository\PaimentRepository;
use App\Repository\UserRepository;
use App\Repository\KeyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

// Implémenter DependentFixtureInterface permet au bundle de savoir
// qu'il va devoir charger d'autres fixtures avant, ce qui va définir 
// un ordre de priorité

class BillFixtures extends Fixture implements DependentFixtureInterface
{
    protected $paimentRepository;
    protected $userRepository;
    protected $keyRepository;

    public function __construct(
        PaimentRepository $paimentRepository,
        UserRepository $userRepository,
        KeyRepository $keyRepository
    ) {
        $this->paimentRepository = $paimentRepository;
        $this->userRepository = $userRepository;
        $this->keyRepository = $keyRepository;
    }

    // // Ici, on va se servir des tags qu'on a déjà inséré en base (pas obligatoire ;) )
    // public function __construct(PlatformRepository $platformRepository)
    // {
    //     $this->platformRepository = $platformRepository;
    // }
    public function load(ObjectManager $manager)
    {
        // C'est dans cette méthode que nous allons créer nos données
        // et les sauvegarder avec l'ObjetManager (un parent de EntityManager)

        // Les titres et contenus des images va être identiques, on les prépare avant la boucle

        $paiments = $this->paimentRepository->findAll();
        $users = $this->userRepository->findAll();
        $keys = $this->keyRepository->findAll();

        $numbers = [
            255588716,
            454165165,
            626587416,
            546878425,
        ];

        foreach ($numbers as $number) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $bill = new Bill();
            $bill->setBillNumber($number);

            $randomNumberOfPaiment = mt_rand(0, count($paiments) - 1);
            $bill->setPaiment($paiments[$randomNumberOfPaiment]);

            $randomNumberOfUser = mt_rand(0, count($users) - 1);
            $bill->setBilluser($users[$randomNumberOfUser]);

            $randomNumberOfKey = mt_rand(0, count($keys) - 1);
            $bill->addKeey($keys[$randomNumberOfKey]);

            $manager->persist($bill);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            PaimentFixtures::class,
            UserFixtures::class,
            KeyFixtures::class,
        ];
    }
}
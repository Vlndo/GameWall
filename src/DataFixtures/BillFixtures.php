<?php

namespace App\DataFixtures;

use App\Entity\Bill;
use App\Repository\ProductRepository;
use App\Repository\PaimentRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

// Implémenter DependentFixtureInterface permet au bundle de savoir
// qu'il va devoir charger d'autres fixtures avant, ce qui va définir 
// un ordre de priorité

class BillFixtures extends Fixture implements DependentFixtureInterface
{
    protected $productRepository;
    protected $paimentRepository;
    protected $userRepository;

    public function __construct(
        ProductRepository $productRepository,
        PaimentRepository $paimentRepository,
        UserRepository $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->paimentRepository = $paimentRepository;
        $this->userRepository = $userRepository;
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

        $products = $this->productRepository->findAll();
        $paiments = $this->paimentRepository->findAll();
        $users = $this->userRepository->findAll();

        $numbers = [
            255588716,
            454165165,
            626587416,
            546878425,
        ];
        $amount = 50;

        foreach ($numbers as $number) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $bill = new Bill();
            $bill->setNumber($number);
            $bill->setAmount($amount);

            $randomNumberOfBill = mt_rand(0, count($products) - 1);
            $bill->addProductbill($products[$randomNumberOfBill]);

            $randomNumberOfPaiment = mt_rand(0, count($paiments) - 1);
            $bill->setPaiment($paiments[$randomNumberOfPaiment]);

            $randomNumberOfUser = mt_rand(0, count($users) - 1);
            $bill->setUser($users[$randomNumberOfUser]);

            $manager->persist($bill);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ProductFixtures::class,
            PaimentFixtures::class,
            UserFixtures::class,
        ];
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Key;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

// Implémenter DependentFixtureInterface permet au bundle de savoir
// qu'il va devoir charger d'autres fixtures avant, ce qui va définir 
// un ordre de priorité
class KeyFixtures extends Fixture implements DependentFixtureInterface
{
    protected $productRepository;

    // // Ici, on va se servir des tags qu'on a déjà inséré en base (pas obligatoire ;) )
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function load(ObjectManager $manager)
    {
        // C'est dans cette méthode que nous allons créer nos données
        // et les sauvegarder avec l'ObjetManager (un parent de EntityManager)

        // Les titres et contenus des images va être identiques, on les prépare avant la boucle
        $products = $this->productRepository->findAll();

        $keyNumbers = [
            'G7BH3-MPAFF-7QLCB',
            'F7BH3-MPAFF-7MLCB',
            'F7BH3-MVAF7-7MLYB',
            'F7JH3-MBAF7-4MLYB',
        ];

        foreach ($keyNumbers as $keyNumber) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $key = new Key();
            $key->setKeyNumber($keyNumber);

            $randomNumberOfProducts = mt_rand(0, count($products) - 1);
            $key->setKeyProduct($products[$randomNumberOfProducts]);

            $manager->persist($key);
        }


        // On sauvegarde effectivement tout en base
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Platform;
use App\Repository\SystemRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

// Implémenter DependentFixtureInterface permet au bundle de savoir
// qu'il va devoir charger d'autres fixtures avant, ce qui va définir 
// un ordre de priorité

class PlatformFixtures extends Fixture implements DependentFixtureInterface
{
    protected $systemRepository;

    public function __construct(SystemRepository $systemRepository)
    {
        $this->systemRepository = $systemRepository;
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

        $systems = $this->systemRepository->findAll();

        $names = [
            "Battle.net",
            "Epic Games",
            "GoG",
            "Microsoft Store",
            "NC Soft",
            "Nintendo Eshop",
            "EA app",
            "Playstation Store",
            "Other",
            "RockStar",
            "Steam",
            "Ubisoft Connect"
        ];

        foreach ($names as $name) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $platform = new Platform();
            $platform->setName($name);

            $randomNumberOfSystem = mt_rand(0, count($systems) - 1);
            $platform->addSystem($systems[$randomNumberOfSystem]);
            $manager->persist($platform);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SystemFixtures::class,
        ];
    }
}
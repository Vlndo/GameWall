<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// Implémenter DependentFixtureInterface permet au bundle de savoir
// qu'il va devoir charger d'autres fixtures avant, ce qui va définir 
// un ordre de priorité
class ImagesFixtures extends Fixture
{
    // protected $imagesRepository;

    // // Ici, on va se servir des tags qu'on a déjà inséré en base (pas obligatoire ;) )
    // public function __construct(ImagesRepository $imagesRepository)
    // {
    //     $this->imagesRepository = $imagesRepository;
    // }
    public function load(ObjectManager $manager)
    {
        // C'est dans cette méthode que nous allons créer nos données
        // et les sauvegarder avec l'ObjetManager (un parent de EntityManager)

        // Les titres et contenus des images va être identiques, on les prépare avant la boucle

        $links = [
            "public/media/img/mw3.jpg",
            "public/media/img/bg3.jpg",
        ];

        foreach ($links as $link) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $image = new Images();
            $image->setLink($link);

            $manager->persist($image);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // C'est dans cette méthode que nous allons créer nos données
        // et les sauvegarder avec l'ObjetManager (un parent de EntityManager)

        // Je veux utiliser des noms de tags qui sonnent un peu réels
        // Même si j'utilise des mots au hasard
        $tagNames = [
            "action",
            "adventure",
            "arcade",
            "beat'em all",
            "cloud gaming",
            "coaching",
            "coop",
            "crossplatform multiplayer",
            "early access",
            "FPS",
            "fighting",
            "F2P",
            "indies",
            "local-coop",
            "MMO",
            "management",
            "multiplayer",
            "online-coop",
            "online-PVP",
            "other",
            "platformer",
            "RPG",
            "racing",
            "remote play together",
            "shoot'em up",
            "simulation",
            "single player",
            "software",
            "sports",
            "strategy",
            "VR",
            "VR-only",
            "war game",
        ];

        foreach ($tagNames as $tagName) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $tag = new Tag();
            $tag->setName($tagName);

            $manager->persist($tag);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }

}
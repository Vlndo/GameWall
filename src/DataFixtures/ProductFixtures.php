<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Repository\TagRepository;
use App\Repository\ImagesRepository;
use App\Repository\PlatformRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    protected $imagesRepository;
    protected $tagRepository;
    protected $platformRepository;

    // Ici, on va se servir des tags qu'on a déjà inséré en base (pas obligatoire ;) )
    public function __construct(
        TagRepository $tagRepository,
        ImagesRepository $imagesRepository,
        PlatformRepository $platformRepository,
    ) {
        $this->tagRepository = $tagRepository;
        $this->imagesRepository = $imagesRepository;
        $this->platformRepository = $platformRepository;
    }
    public function load(ObjectManager $manager)
    {
        // C'est dans cette méthode que nous allons créer nos données
        // et les sauvegarder avec l'ObjetManager (un parent de EntityManager)

        // Les titres et contenus des products va être identiques, on les prépare avant la boucle

        $platforms = $this->platformRepository->findAll();
        $images = $this->imagesRepository->findAll();
        // Pour les utiliser dans les products, on récupère la liste complète de nos tags
        $tags = $this->tagRepository->findAll();

        $title = 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...';
        $quantity = 3;
        $price = 59.99;
        $releaseDate = new DateTime();
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce luctus neque justo, id vulputate velit malesuada in. Donec vulputate ipsum vitae orci vestibulum, et tempus orci hendrerit. Vestibulum mattis sit amet eros sodales accumsan. Proin auctor tellus vitae hendrerit viverra. Aliquam erat volutpat. Duis suscipit lacus tortor, non hendrerit sapien dapibus vel. Phasellus urna orci, porta vel arcu vitae, posuere efficitur diam. Phasellus convallis ante enim, a lobortis tortor fermentum et. Aenean hendrerit congue nulla quis interdum. Nullam quis magna sem. Duis quis pulvinar ante, ac posuere velit.";
        $rate = 2;
        $productcontent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce luctus neque justo, id vulputate velit malesuada in. Donec vulputate ipsum vitae orci vestibulum, et tempus orci hendrerit. Vestibulum mattis sit amet eros sodales accumsan. Proin auctor tellus vitae hendrerit viverra. Aliquam erat volutpat. Duis suscipit lacus tortor, non hendrerit sapien dapibus vel. Phasellus urna orci, porta vel arcu vitae, posuere efficitur diam. Phasellus convallis ante enim, a lobortis tortor fermentum et. Aenean hendrerit congue nulla quis interdum. Nullam quis magna sem. Duis quis pulvinar ante, ac posuere velit.";
        $requiredspecs = "Un pc de fou malade";
        $edition = "standard";


        // On crée une dizaine d'products
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setTitle($i . $title);
            $product->setQuantity($quantity);
            $product->setPrice($price);
            $product->setReleaseDate($releaseDate);
            $product->setDescription($description);
            $product->setRate($rate);
            $product->setProductcontent($productcontent);
            $product->setRequiredspecs($requiredspecs);
            $product->setEdition($edition);
            $product->addImage($images[1]);

            $randomNumberOfPlatforms = mt_rand(0, count($platforms) - 1);
            $product->addPlatform($platforms[$randomNumberOfPlatforms]);
            // On récupère un tag aléatoire dans la liste $tags, qu'on va associer à notre product
            $randomNumberOfTags = mt_rand(0, count($tags) - 1);
            $product->addTag($tags[$randomNumberOfTags]); // Si $randomNumber contient 0, on récupère notre 1er tag

            // On prépare l'product à l'insertion en base
            $manager->persist($product);
        }

        // On sauvegarde effectivement tout en base
        $manager->flush();
    }

    // Cette méthode sert à dire au bundle quelles fixtures
    // doivent être appliquées avant celles-ci
    public function getDependencies()
    {
        return [
            TagFixtures::class,
            ImagesFixtures::class,
            PlatformFixtures::class,
        ];
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Painting;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaintingFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $uploadPaintingDir = $this->parameterBag->get('upload_painting_directory');

        if (!is_dir(__DIR__ . '/../../public/' . $uploadPaintingDir)) {
            mkdir(__DIR__ . '/../../public/' . $uploadPaintingDir, recursive: true);
        }

        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            copy(
                __DIR__ . '/data/paintings/' . 'reeunion_de_famille187438.jpg',
                __DIR__ . '/../../public/' . $uploadPaintingDir . '/' . 'reeunion_de_famille187438.jpg'
            );
            $painting = new Painting();
            $painting->setTitle($faker->sentence(3));
            $painting->setDate($faker->dateTime());
            $painting->setAnecdote($faker->paragraph(4));
            $painting->setHeight($faker->numberBetween(50, 150));
            $painting->setWidth($faker->numberBetween(50, 150));
            $painting->setImage('reeunion_de_famille187438.jpg');
            $painting->setCreatedAt(new DateTime('now'));
            $painting->setArtist($this->getReference('artist_' . $faker->numberBetween(1, 7)));
            $painting->setCategory($this->getReference('category_' . ($i % 4 + 1)));
            $manager->persist($painting);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return[
            ArtistFixtures::class,
            CategoryFixtures::class,
        ];
    }
}

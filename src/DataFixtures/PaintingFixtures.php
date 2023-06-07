<?php

namespace App\DataFixtures;

use App\Entity\Painting;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PaintingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $painting = new Painting();
            $painting->setTitle($faker->sentence(3));
            $painting->setDate($faker->dateTime());
            $painting->setAnecdote($faker->paragraph(4));
            $painting->setHeight($faker->numberBetween(50, 150));
            $painting->setWidth($faker->numberBetween(50, 150));
            $painting->setImage('"https://fakeimg.pl/1000x800/"');
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

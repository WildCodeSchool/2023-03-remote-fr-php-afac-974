<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $artist = new Artist();
        $artist->setName('Hypolite Charles Napoleon Mortier');
        $artist->setDateofBirth($faker->dateTime());
        $artist->setNationality('French');
        $artist->setBiography($faker->paragraph(7));
        $manager->persist($artist);
        for ($i = 0; $i < 5; $i++) {
            $artist = new Artist();
            $artist->setName($faker->name());
            $artist->setDateofBirth($faker->dateTime());
            $artist->setNationality('French');
            $artist->setBiography($faker->paragraph(7));
            $manager->persist($artist);
        }

        $manager->flush();
    }
}

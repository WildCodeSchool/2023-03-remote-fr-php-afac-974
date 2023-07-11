<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArtistFixtures extends Fixture
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $artist = new Artist();
        $artist->setName('Hypolite Charles Napoleon Mortier');
        $artist->setDateofBirth($faker->dateTime());
        $artist->setNationality('Français·e');
        $slug = $this->slugger->slug($artist->getName());
        $artist->setSlug($slug);
        $artist->setBiography($faker->paragraph(7));
        $this->addReference('artist_1', $artist);
        $manager->persist($artist);
        for ($i = 1; $i < 7; $i++) {
            $artist = new Artist();
            $artist->setName($faker->name());
            $artist->setDateofBirth($faker->dateTime());
            $artist->setNationality('Français·e');
            $slug = $this->slugger->slug($artist->getName());
            $artist->setSlug($slug);
            $artist->setBiography($faker->paragraph(7));
            $this->addReference('artist_' . ($i % 7 + 1), $artist);
            $manager->persist($artist);
        }

        $manager->flush();
    }
}

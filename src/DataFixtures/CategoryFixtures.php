<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY = [
        [
            'name' => "Aquarelle",
            'reference' => 'category_1'
        ],
        [
            'name' => "Dessin",
            'reference' => 'category_2'
        ],
        [
            'name' => "Peinture à l'huile",
            'reference' => 'category_3'
        ],
        [
            'name' => "Gravure",
            'reference' => 'category_4'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORY as $categoryName) {
            $category = new Category();
            $category->setName($categoryName['name']);
            $this->addReference($categoryName['reference'], $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $names = [
            'rotations',
            'flips',
            'airs',
            'slides',
            'freestyle'
        ];

        foreach($names as $name)
        {
            $category = new Category($name);

            $manager->persist($category);
        }
        $manager->flush();
    }
}
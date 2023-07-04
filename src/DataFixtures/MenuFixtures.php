<?php
namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MenuFixtures extends Fixture {

    public function load(ObjectManager $manager)  
    {
       $faker = Factory::create('fr_FR');

        for($i=0; $i<10; $i++)
        {
            $menu = new Menu();

            $menu->setName($faker->name);
            $menu->setPrice($faker->randomNumber(2));
            $menu->setDescription($faker->text);
            $menu->setOffre($faker->randomNumber(1));
            $menu->setImage($faker->safeHexColor());

            $manager->persist($menu);
        }

        $manager->flush();

    }
    
}
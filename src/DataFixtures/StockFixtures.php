<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Stock;

class StockFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
 
        for ($i = 0; $i < 10; $i++) {

            $stock = new Stock();
            $stock->setName($faker->name());
            $stock->setDescription($faker->text());
            $stock->setQuantity(mt_rand(1, 20));
            $stock->setPrice(mt_rand(10, 100));
            $manager->persist($stock);
        }

        $manager->flush();
    }

}
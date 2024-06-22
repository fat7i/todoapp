<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Enum\StatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            $todo = new Todo();
            $todo->setTitle($faker->sentence(3));
            $todo->setDescription($faker->paragraph());
            $todo->setStatus($faker->randomElement(StatusEnum::cases()));
            $todo->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($todo);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Factory\BudgetEntryFactory;
use App\Factory\BudgetFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = UserFactory::createOne([
           'email' => 'name@email.com',
           'isVerified' => true,
        ]);
        $budgetEntry = [BudgetEntryFactory::createOne(), BudgetEntryFactory::createOne(), BudgetEntryFactory::createOne()];

        BudgetFactory::createOne([
            'budgetEntries' => $budgetEntry,
            'user' => $user,
        ]);
    }
}

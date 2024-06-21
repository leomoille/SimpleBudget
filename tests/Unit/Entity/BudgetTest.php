<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Budget;
use App\Entity\BudgetEntry;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BudgetTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $budget = new Budget();
        $name   = 'Test Budget';
        $user   = new User();

        $budget
            ->setName($name)
            ->setUser($user);

        $this->assertEquals($name, $budget->getName());
        $this->assertEquals($user, $budget->getUser());
    }

    public function testAddAndRemoveBudgetEntry()
    {
        $budget      = new Budget();
        $budgetEntry = new BudgetEntry();

        $budget->addBudgetEntry($budgetEntry);
        $this->assertTrue($budget->getBudgetEntries()->contains($budgetEntry));

        $budget->removeBudgetEntry($budgetEntry);
        $this->assertFalse($budget->getBudgetEntries()->contains($budgetEntry));
    }

    public function testTotal()
    {
        $budget       = new Budget();
        $budgetEntry1 = new BudgetEntry();
        $budgetEntry1->setValue(1000.50);
        $budgetEntry2 = new BudgetEntry();
        $budgetEntry2->setValue(500.75);

        $budget->addBudgetEntry($budgetEntry1);
        $budget->addBudgetEntry($budgetEntry2);

        $this->assertEquals(1501.25, $budget->getTotal());
    }
}

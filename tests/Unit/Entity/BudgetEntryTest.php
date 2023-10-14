<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Budget;
use App\Entity\BudgetEntry;
use PHPUnit\Framework\TestCase;

class BudgetEntryTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $budgetEntry = new BudgetEntry();
        $name = 'Test Entry';
        $value = 1000.50;
        $notes = 'This is a test entry';
        $budget = new Budget();

        $budgetEntry
            ->setName($name)
            ->setValue($value)
            ->setNotes($notes)
            ->setBudget($budget);

        $this->assertEquals($name, $budgetEntry->getName());
        $this->assertEquals($value, $budgetEntry->getValue());
        $this->assertEquals($notes, $budgetEntry->getNotes());
        $this->assertEquals($budget, $budgetEntry->getBudget());
    }

    public function testValueConversion()
    {
        $budgetEntry = new BudgetEntry();
        $value = 1000.50;

        $budgetEntry->setValue($value);

        $this->assertEquals($value, $budgetEntry->getValue());
    }
}

<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Budget;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $user     = new User();
        $email    = 'test@example.com';
        $roles    = ['ROLE_USER'];
        $password = 'password123';
        $pseudo   = 'TestUser';

        $user
            ->setEmail($email)
            ->setRoles($roles)
            ->setPassword($password)
            ->setPseudo($pseudo)
            ->setIsVerified(true);

        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($pseudo, $user->getPseudo());
        $this->assertTrue($user->isVerified());
    }

    public function testBudgetRelationship()
    {
        $user   = new User();
        $budget = new Budget();

        $user->addBudget($budget);
        $this->assertTrue($user->getBudgets()->contains($budget));
        $this->assertSame($user, $budget->getUser());

        $user->removeBudget($budget);
        $this->assertFalse($user->getBudgets()->contains($budget));
        $this->assertNull($budget->getUser());
    }
}

<?php

namespace App\Tests\Unit\Service;

use App\Entity\Budget;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserAuthorizationChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAuthorizationCheckerTest extends TestCase
{
    public function testIsVerifiedWithUser()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $checker = new UserAuthorizationChecker($userRepository);

        $user = new User();
        $user->setIsVerified(true);

        $userRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $user->getId()])
            ->willReturn($user);

        $this->assertTrue($checker->isVerified($user));
    }

    public function testIsVerifiedWithNonUser()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $checker = new UserAuthorizationChecker($userRepository);

        $nonUser = $this->createMock(UserInterface::class);

        $this->assertFalse($checker->isVerified($nonUser));
    }

    public function testCheckBudgetAccessWithMatchingUser()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $checker = new UserAuthorizationChecker($userRepository);

        $user = new User();
        $budget = new Budget();
        $budget->setUser($user);

        $this->assertTrue($checker->checkBudgetAccess($user, $budget));
    }

    public function testCheckBudgetAccessWithNonMatchingUser()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $checker = new UserAuthorizationChecker($userRepository);

        $user1 = new User();
        $user2 = new User();
        $budget = new Budget();
        $budget->setUser($user1);

        $this->assertFalse($checker->checkBudgetAccess($user2, $budget));
    }

    public function testCheckBudgetAccessWithNullBudget()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $checker = new UserAuthorizationChecker($userRepository);

        $user = new User();

        $this->assertFalse($checker->checkBudgetAccess($user, null));
    }
}

<?php

namespace App\Service;

use App\Entity\Budget;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAuthorizationChecker
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isVerified(UserInterface $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        $currentUser = $this->userRepository->findOneBy(['id' => $user->getId()]);

        return null !== $currentUser && $currentUser->isVerified();
    }

    public function checkBudgetAccess(UserInterface $user, Budget $budget = null): bool
    {
        return null !== $budget && $user === $budget->getUser();
    }
}

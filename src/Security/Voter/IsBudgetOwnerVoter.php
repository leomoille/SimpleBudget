<?php

namespace App\Security\Voter;

use App\Entity\Budget;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class IsBudgetOwnerVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        return 'BUDGET_OWNER' === $attribute && $subject instanceof Budget;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return $subject->getUser() === $user;
    }
}

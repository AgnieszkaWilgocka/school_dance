<?php

namespace App\Security\Voter;

use App\Entity\MyClasses;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class MyClassesVoter extends Voter
{
    public const EDIT = 'EDIT';

    public const VIEW = 'VIEW';

    public const DELETE = "DELETE";

    private Security $security;

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\MyClasses;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::VIEW:
                return $this->canView($subject, $user);
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }


        return false;
    }

    private function canEdit(MyClasses $myClasses, User $user): bool
    {
        return $myClasses->getAuthor() === $user;
    }

    private function canView(MyClasses $myClasses, User $user): bool
    {
        return $myClasses->getAuthor() === $user;
    }

    private function canDelete(MyClasses $myClasses, User $user): bool
    {
        return $myClasses->getAuthor() === $user;
    }
}

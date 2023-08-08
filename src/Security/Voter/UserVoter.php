<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{

    private Security $security;
//    public const EDIT = 'EDIT';
//    public const VIEW = 'VIEW';
//
//    public const DELETE = "DELETE";
    public function __construct(Security $security) {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ["USER_VIEW", "USER_EDIT", "USER_DELETE"])
            && $subject instanceof \App\Entity\User;
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
            case "USER_VIEW":
                if($subject == $user || $this->security->isGranted('ROLE_ADMIN', $user)) {
                    return true;

                }
//                return $this->canEdit($subject, $user);
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case "USER_EDIT":
                if($subject == $user || $this->security->isGranted('ROLE_ADMIN', $user)) {
                    return true;

                }
//                return $this->canView($subject, $user);
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case "USER_DELETE":
                if($subject == $user || $this->security->isGranted('ROLE_ADMIN', $user)) {
                    return true;

                }
                break;
            default:
                return false;
                break;
//                return $this->canDelete($subject, $user);
        }

        return false;
    }

//    private function canView(User $user)
}

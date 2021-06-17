<?php


namespace App\Security\Voter;


use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PostVoter
 * @package App\Security\Voter
 */
class PostVoter extends Voter
{

    public const POST_EDIT="edit";
    protected function supports(string $attribute, $subject)
    {
        if(!$subject instanceof Post){
            return false;
        }

        if(!in_array($attribute,[self::POST_EDIT])){
            return false;
        }


        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /**
         * @var User $user
         */
        $user = $token->getUser();

        switch ($attribute){
            case self::POST_EDIT:
                return  $user===$subject->getUser();
                break;
        }
    }


}
<?php


namespace App\DataFixtures;

use App\DataFixtures\PostFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends  Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */

    private UserPasswordEncoderInterface $userPasswordEncoder;

    private function __construct( UserPasswordEncoderInterface $userPasswordEncoder){
        $this->userPasswordEncoder = $userPasswordEncoder;

    }

    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=10; $i++){
            $user = new User();
            $user->setEmail(sprintf("email+%d@email.com",$i));
            //$user->setPseudo(sprintf("pseudo+%d",$i));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user,"password"));
            $manager->persist($user);
           // $this->setReference(sprintf("user-%d",$i),$user);
        }
        $manager->flush();
    }

}
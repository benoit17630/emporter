<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $Encoder;

    public function __construct(UserPasswordEncoderInterface $Encoder){

        $this->Encoder = $Encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user =new User();
        $user->setEmail("benoit.menier@orange.fr");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->Encoder->encodePassword($user,'noirot17'));

         $manager->persist($user);

        $manager->flush();
    }
}

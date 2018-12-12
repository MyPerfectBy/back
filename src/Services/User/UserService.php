<?php
namespace App\Services\User;

use App\Entity\Security\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;


class UserService
{
    private $container;
    /**@var $em EntityManager */
    private $em;

    /**@throws */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.entity_manager');

    }


    public function registerUser($input){
        $checkUser = $this->em->getRepository('UserRepository')->findBy(['email'=>$input['email']]);
        if($checkUser) return 'error';

        $user = new User();
        $user ->setEmail($input['email']);
        $user ->setRegisterDate(new \DateTime());
        $user->setRegisterCode(md5($input['email']+random_bytes(8)));

        $this->em->persist($user);
        $this->em->flush();

    }

}
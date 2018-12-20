<?php

namespace App\Service;


use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\DependencyInjection\Container;


class ProfileServicesService
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

    public function getProfileServices(){
        return $this->em->getRepository("App:ProfileServices")->findBy(['active'=>true]);
    }

}
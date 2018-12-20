<?php

namespace App\Service;

use App\Entity\Security\User;
use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\DependencyInjection\Container;


class ServicesService
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

    public function getServices(){
        return  $this->em->getRepository("App:Services")->findAll();
    }
}
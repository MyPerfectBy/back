<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;


class CityService
{
    /** @var $container Container  */
    private $container;

    /** @var $em EntityManager */
    private $em;

    /**
     * @param $container
     * @throws
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.entity_manager');

    }

    /**
     * @return array|\Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    public function getCities(){

        return  $this->em->getRepository("App:Cities")->findAll();
    }

}
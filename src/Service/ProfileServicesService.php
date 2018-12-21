<?php

namespace App\Service;


use App\Entity\Profile;
use App\Entity\ProfileServices;
use App\Entity\Services;
use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use Symfony\Component\DependencyInjection\Container;


class ProfileServicesService
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
    public function getProfileServices(){
        return $this->em->getRepository("App:ProfileServices")->findBy(['active'=>true]);
    }


    /**
     * @param $args
     * @return ProfileServices
     * @throws \Exception
     */
    public function addProfileService($args){

        /** @var Profile $profile */
        $profile =  $this->container->get("profile.service")->getProfile();
        if(!$profile) throw new UserError(sprintf('Could not find people profile'));

        /** @var Services $service */
        $service = $this->em->getRepository("App:Services")->find($args['service']);
        if(!$service) throw new UserError(sprintf('Could not find service'));

        $profileService =  new ProfileServices();
        $profileService -> setProfile($profile);
        $profileService -> setPrice($args['price']);
        $profileService -> setService($service);
        $profileService -> setActive(true);
        try{
            $this->em->persist($profileService);
            $this->em->flush();
        } catch (\Throwable $t){
            throw new UserError(sprintf('Database flush error'));
        }

        return $profileService;
    }


    /**
     * @param $args
     * @return ProfileServices
     * @throws \Exception
     */
    public function changeActiveProfileService($args){
        /** @var Profile $profile */
        $profile =  $this->container->get("profile.service")->getProfile();
        if(!$profile) throw new UserError(sprintf('Could not find people profile'));

        /** @var ProfileServices $profileService */
        $profileService = $this->em->getRepository("App:ProfileServices")->findOneBy(["id"=>$args['profileService'], "profile"=>$profile]);
        if(!$profileService)  throw new UserError(sprintf('Could not find profile service'));

        $profileService -> setActive($args['active']);
        try{
            $this->em->flush();
        } catch (\Throwable $t){
            throw new UserError(sprintf('Database flush error'));
        }

        return $profileService;
    }

}
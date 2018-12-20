<?php

namespace App\Service;

use App\Entity\Profile;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\DependencyInjection\Container;


class ProfileService
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


    public function getProfile() :Profile
    {
        /** @var User $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        /** @var Profile $profile */
        $profile = $this->em->getRepository("App:Profile")->findOneBy(['user'=>$user]);

        if (!$profile) {
            throw new UserError(sprintf('Could not find people profile #%d'));
        }

        return $profile;
    }

    /**
     * @param $args
     * @return Profile|\Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository|null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function mutationProfile($args){
        /** @var Profile $profile */
        $profile = $this->em->getRepository("App:Profile")->find($args["id"]);
        if(!$profile) throw new UserError(sprintf('Could not find people profile #%d', $args['id']));
        $action = 'mutationProfile';

        if(array_key_exists("title",$args) && $args['title'])
        {
            $profile->setTitle($args['title']);
        }

        if(array_key_exists("description",$args))
        {
            $profile->setDescription($args['description']);
        }

//        if(array_key_exists("types",$args))
//        {
//            $newTypes = $this->em->getRepository('App\Entity\People\ProfileType')->findBy(['uuid'=>$args['types']]);
//
//
//            $oldTypes = $profile->getTypes();
//
//            foreach ($oldTypes as $oldType){
//                $profile->removeTypes($oldType);
//            }
//
//            foreach ($newTypes as $newType){
//                $profile->addTypes($newType);
//            }
//
//        }

        if(array_key_exists("address",$args))
        {

            $profile->setAddress($args['address']);
        }

        $this->em->flush();

       // на сокет отправка
       // $event = new SendSocketUpdateEvent($this->serializableProfile($action, $profile));

       // $this->container->get("event_dispatcher")->dispatch("send_socket_update", $event);

        return $profile;

    }
}
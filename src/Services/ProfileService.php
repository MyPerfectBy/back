<?php
namespace App\Services;

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
}
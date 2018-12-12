<?php
namespace App\Services\User;

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

//    /**
//     * @param $args
//     * @return Profile
//     */
//    public function getProfile(Argument $args) :Profile
//    {
//        $user = $this->container->getUser();
//        /** @var Profile $profile */
//        $profile = $this->em->getRepository("App:People\Profile")->find($args["id"]);
//
//        if (!$profile) {
//            throw new UserError(sprintf('Could not find people profile #%d', $args['id']));
//        }
//
//        return $profile;
//    }
}
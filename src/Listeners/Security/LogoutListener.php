<?php
namespace App\Listeners\Security;

use App\Entity\Security\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
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
    /**
     * @{inheritDoc}
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();


    }
}
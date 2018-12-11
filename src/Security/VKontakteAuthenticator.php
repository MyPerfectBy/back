<?php

namespace App\Security;

use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\VKontakteClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class VKontakteAuthenticator extends SocialAuthenticator
{
    private $em;
    private $clientRegistry;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {

        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_vkontakte_check';
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getVKontakteClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        $vkontakteUser = $this->getVKontakteClient()
            ->fetchUserFromToken($credentials);

        $email = $vkontakteUser->getEmail();


        $existingUser = $this->em->getRepository(User::class)
            ->findOneBy(['vkontakteId' => $vkontakteUser->getId()]);
        if ($existingUser) {
            return $existingUser;
        }

     /* @var User $user */
        $user = $this->em->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        // 3) Maybe you just want to "register" them by creating
        // a User object
        $user->setVkontakteId($vkontakteUser->getId());
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @return VKontakteClient
     */
    private function getVKontakteClient()
    {
        return $this->clientRegistry
            // "vkontakte" is the key used in config/packages/knpu_oauth2_client.yaml
            ->getClient('vkontakte');
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
// on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

// or to translate this message
// $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new Response($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse(
            '/connect/', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
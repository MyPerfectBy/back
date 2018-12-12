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
        return $request->attributes->get('_route') === 'connect_vkontakte_start';
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        $url = 'https://oauth.vk.com/access_token?client_id=' . $_ENV['OAUTH_VKONTAKTE_CLIENT_ID'] . '&client_secret='.
            $_ENV['OAUTH_VKONTAKTE_CLIENT_SECRET'].'&redirect_uri=http://dev.makeperfect.by&code='.$request->get('code');


        $out ='';
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);

            curl_close($curl);


        }

        $data = json_decode($out, true);

        if (isset($data['error']) || !$data){
            return false;
        }

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {


        $vkontakteUserId = $credentials['user_id'];


        $existingUser = $this->em->getRepository(User::class)
            ->findOneBy(['vkontakteId' => $vkontakteUserId]);
        if ($existingUser) {
            return $existingUser;
        }


        $email = '';
        /* @var User $user */
        if (isset($credentials['email'])) {
            $email = $credentials['email'];
            $user = $this->em->getRepository(User::class)
                ->findOneBy(['email' => $email]);
        }

        if (!isset($user)) {
            $user = new User();
        }




        $user->setEmail($email);
        $user->setVkontakteId($vkontakteUserId);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
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
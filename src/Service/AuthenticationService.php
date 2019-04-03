<?php
/**
 * Created by PhpStorm.
 * User: teo
 * Date: 20/03/19
 * Time: 15:26
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;


class AuthenticationService
{
    const SESSION_KEY = '_authentication';

    private $session;
    private $apiClient;

    public function __construct(SessionInterface $session, ApiClient $apiClient)
    {
        $this->session = $session;
        $this->apiClient = $apiClient;
    }

    public function authenticateUser($username, $password)
    {
        $user = $this->apiClient->postAuthentication($username, $password);

        $this->session->set(self::SESSION_KEY, $user);

        return $user;
    }

    public function getUser()
    {
        return $this->session->get(self::SESSION_KEY);
    }
}

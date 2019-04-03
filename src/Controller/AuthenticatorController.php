<?php

namespace App\Controller;

use App\Service\ApiClient;
use App\Service\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticatorController extends Controller
{
    private $apiClient;
    private $authenticationService;

    public function __construct(ApiClient $apiClient, AuthenticationService $authenticationService)
    {
        $this->apiClient = $apiClient;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $this->getLogInInfo($request);

            $resource = $this->authenticationService->authenticateUser(
                $data['username'],
                $data['password']
            );

            var_dump($resource);
            die();
        }

        return $this->render('new.html.twig');
    }

    private function getLogInInfo(Request $request)
    {
        $data['username'] = $request->get('username', '');
        $data['password'] = $request->get('password', '');

        return $data;
    }
}

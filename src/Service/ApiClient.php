<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function postAuthentication(string $username, string $password): array
    {
        try {
            $response = $this->client->request('POST', 'users/authentication', [
                'json' => ['username' => $username,
                    'password' => $password]
            ]);
            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
        }
    }

    public function getProductsList($user)
    {
        try {
            $response = $this->client->request('GET', 'products', [
                'headers' => ['X-AUTH-TOKEN' => $user['token']]
            ]);

            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
        }
    }

    public function getProduct($id, $user)
    {
        try {
            $response = $this->client->request(
                'GET',
                'products/' . $id,
                [
                    'headers' => ['X-AUTH-TOKEN' => $user['token']]
                ]
            );

            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
        }
    }

    public function createProduct($user, $data)
    {
        try {
            $response = $this->client->request('POST', 'products/', [
                'headers' => ['X-AUTH-TOKEN' => $user['token']],
                'json' => ['name' => $data['name'],
                    'price' => (int)$data['price'],
                    'category' => (int)$data['category'],
                    'description' => $data['description'],
                    'attributes' => []]
            ]);

            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
        }
    }

    public function editProduct($user, $data)
    {
        try {
            var_dump($user['token']);
            $uri = 'products/'.$data['id'];
            $response = $this->client->request('PUT', $uri, [
                'headers' => ['X-AUTH-TOKEN' => $user['token']],
                'json' => ['name' => $data['name'],
                    'price' => (int)$data['price'],
                    'category' => (int)$data['category'],
                    'description' => $data['description']]
            ]);

            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }
    }

    public function getCategories($user)
    {
        try {
            $response = $this->client->request('GET', 'categories', [
                'headers' => ['X-AUTH-TOKEN' => $user['token']]
            ]);

            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
        }
    }

    public function deleteProduct($user, $id)
    {
        try {
            $response = $this->client->request('DELETE', 'products/' . $id, [
                'headers' => ['X-AUTH-TOKEN' => $user['token']]
            ]);

            $body = $response->getBody();
            $resource = json_decode($body, true);

            return $resource;
        } catch (GuzzleException $e) {
        }
    }

}
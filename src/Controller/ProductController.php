<?php
/**
 * Created by PhpStorm.
 * User: teo
 * Date: 27/03/19
 * Time: 12:55
 */

namespace App\Controller;

use App\Service\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\AuthenticationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    private $apiClient;
    private $authenticationService;

    public function __construct(ApiClient $apiClient, AuthenticationService $authenticationService)
    {
        $this->apiClient = $apiClient;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @Route("/product/new", name="create_product")
     */
    public function createProduct(Request $request)
    {
        $user = $this->authenticationService->getUser();

        if ($request->isMethod('POST')) {
            $data['name'] = $request->get('name', '');
            $data['price'] = $request->get('price', '');
            $data['category'] = $request->get('category', '');
            $data['description'] = $request->get('description');

            $this->apiClient->createProduct($user, $data);

            return $this->redirectToRoute("products");
        }

        $categories = $this->apiClient->getCategories($user);

        return $this->render('product/form.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/product/list", name="products")
     */
    public function getProductsList()
    {
        $resource = $this->apiClient->getProductsList($this->authenticationService->getUser());

        return $this->render('product/productList.html.twig', [
            'product' => $resource
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="edit_product")
     */
    public function editProduct($id, Request $request)
    {
        $user = $this->authenticationService->getUser();

        if ($request->isMethod('POST')) {
            $data['name'] = $request->get('name', '');
            $data['price'] = $request->get('price', '');
            $data['category'] = $request->get('category');
            $data['description'] = $request->get('description');
            $data['id'] = $id;

            $this->apiClient->editProduct($user, $data);

            return $this->redirectToRoute("products");
        }

        $categories = $this->apiClient->getCategories($user);
        $product = $this->apiClient->getProduct($id, $user);

        return $this->render('product/form.html.twig', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="delete_product")
     */
    public function deleteProduct($id)
    {
        $user = $this->authenticationService->getUser();

        $this->apiClient->deleteProduct($user, $id);

        return $this->redirectToRoute("products");
    }
}
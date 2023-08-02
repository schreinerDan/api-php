<?php

namespace Controllers;

use Services\ProductService;
use Repositories\ProductRepository;
use Models\Product;
use Core\Router;
use Core\Messages;
use Core\PgsqlSingleton;

class ProductController implements IController
{
    private $service;

    public function __construct()
    {
        $dbi = PgsqlSingleton::getInstance();
        $repository = new ProductRepository($dbi);
        $repository->table = 'products';
        $this->service = new ProductService($repository);
    }

    /**
     * Get all products
     */
    public function getAll()
    {
        $products = $this->service->getAllProducts();
        echo json_encode($products);
    }

    /**
     * Get product by id
     */
    public function getById($params)
    {
        $productId = $params['id'];

        $existingProduct = $this->service->getProductById($productId);
        if (!$existingProduct) {
            http_response_code(404);
            Messages::notFound('Product');
            return;
        }
        echo json_encode($existingProduct);
    }

    /**
     * Create a new product
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data) || !isset($data['name']) || !isset($data['price'])) {
            http_response_code(400);
            Messages::invalidRequestData();
            return;
        }

        $product = new Product($data);

        $result = $this->service->createProduct($product);

        if ($result) {
            http_response_code(201);
            Messages::actionSuccess('created','Product');
        } else {
            http_response_code(500);
            Messages::actionFailed('create','Product');
        }
    }

    /**
     * Updates
     */
    public function update($params)
    {
        $productId = $params['id'];

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data)) {
            http_response_code(400);
            Messages::invalidRequestData();
            return;
        }

        $existingProduct = $this->service->getProductById($productId);

        if (!$existingProduct) {
            http_response_code(404);
            Messages::notFound('Product');
            return;
        }

        $product = new Product($data);

        $result = $this->service->updateProduct($productId, $product);

        if ($result) {
            http_response_code(200);
            
            Messages::actionSuccess('updated','Product');
        } else {
            http_response_code(500);
            Messages::actionFailed('update','Product');
        }
    }

    /**
     * Delete a product
     */
    public function delete($params)
    {
        $productId = $params['id'];
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $existingProduct = $this->service->getProductById($productId);

        if (!$existingProduct) {
            http_response_code(404);
            Messages::notFound('Product');
            return;
        }

        $result = $this->service->deleteProduct($productId);

        if ($result) {
            http_response_code(200);
            Messages::actionSuccess('removed','Product');
        } else {
            http_response_code(500);
            Messages::actionFailed('remove','Product');
        }
    }
}

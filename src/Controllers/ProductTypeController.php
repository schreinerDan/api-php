<?php

namespace Controllers;

use Services\ProductTypeService;
use Repositories\ProductTypeRepository;
use Models\ProductType;
use Core\Messages;
use Core\PgsqlSingleton;

class ProductTypeController implements IController
{
    private $service;

    public function __construct()
    {
        $dbi = PgsqlSingleton::getInstance();
        $repository = new ProductTypeRepository($dbi);
        $repository->table = 'product_types';
        $this->service = new ProductTypeService($repository);
    }

    /**
     * Get all products
     */
    public function getAll()
    {
        $productType = $this->service->getAllProductTypes();
        echo json_encode($productType);
    }

    /**
     * Get product by id
     */
    public function getById($params)
    {
        $productId = $params['id'];

        $existingProductType = $this->service->getProductTypeById($productId);
        if (!$existingProductType) {
            http_response_code(404);
            Messages::notFound('Product Type');
            return;
        }
        echo json_encode($existingProductType);
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

        if (empty($data) || !isset($data['name']) ) {
            http_response_code(400);
            Messages::invalidRequestData();
            return;
        }

        $productType = new ProductType($data);

        $result = $this->service->createProductType($productType);

        if ($result) {
            http_response_code(201);
            Messages::actionSuccess('created','Product Type');
        } else {
            http_response_code(500);
            Messages::actionFailed('create','Product Type');
        }
    }

    /**
     * Updates
     */
    public function update($params)
    {
        $productTypeId = $params['id'];

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

        $existingProductType = $this->service->getProductTypeById($productTypeId);

        if (!$existingProductType) {
            http_response_code(404);
            Messages::notFound('Product Type');
            return;
        }

        $productType = new ProductType($data);

        $result = $this->service->updateProductType($productTypeId, $productType);

        if ($result) {
            http_response_code(200);
            
            Messages::actionSuccess('updated','Product Type');
        } else {
            http_response_code(500);
            Messages::actionFailed('update','Product Type');
        }
    }

    /**
     * Delete a product
     */
    public function delete($params)
    {
        $productTypeId = $params['id'];
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $existingProductType = $this->service->getProductTypeById($productTypeId);

        if (!$existingProductType) {
            http_response_code(404);
            Messages::notFound('Product Type');
            return;
        }

        $result = $this->service->deleteProductType($productTypeId);

        if ($result) {
            http_response_code(200);
            Messages::actionSuccess('removed','Product Type');
        } else {
            http_response_code(500);
            Messages::actionFailed('remove','Product Type');
        }
    }
}

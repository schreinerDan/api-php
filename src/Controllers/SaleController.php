<?php

namespace Controllers;

use Services\SaleService;
use Repositories\SaleRepository;
use Models\Sale;
use Core\Router;
use Core\Messages;
use Core\PgsqlSingleton;

class SaleController implements IController
{
    private $service;

    public function __construct()
    {
        $dbi = PgsqlSingleton::getInstance();
        $repository = new SaleRepository($dbi);
        $repository->table = 'sales';
        $this->service = new SaleService($repository);
    }

    /**
     * Get all sales
     */
    public function getAll()
    {
        $sales = $this->service->getAllSales();
        echo json_encode($sales);
    }

    /**
     * Get sale by id
     */
    public function getById($params)
    {
        $saleId = $params['id'];

        $sale = $this->service->getSaleById($saleId);
        echo json_encode($sale);
    }

    /**
     * Create a new sale
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        // if (empty($data) || !isset($data['name']) || !isset($data['price'])) {
        //     http_response_code(400);
        //     Messages::invalidRequestData();
        //     return;
        // }

        $sale = new Sale($data);

        $result = $this->service->createSale($sale);

        if ($result) {
            http_response_code(201);
            Messages::actionSuccess('created','Sale');
        } else {
            http_response_code(500);
            Messages::actionFailed('create','Sale');
        }
    }

    /**
     * Updates
     */
    public function update($params)
    {
        $saleId = $params['id'];

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

        $existingProduct = $this->service->getSaleById($saleId);

        if (!$existingProduct) {
            http_response_code(404);
            Messages::notFound('Product');
            return;
        }

        $sale = new Sale($data);

        $result = $this->service->updateSale($saleId, $sale);

        if ($result) {
            http_response_code(200);
            
            Messages::actionSuccess('updated','Sale');
        } else {
            http_response_code(500);
            Messages::actionFailed('update','Sale');
        }
    }

    /**
     * Delete a sale
     */
    public function delete($params)
    {
        $saleId = $params['id'];
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $existingSale = $this->service->getSaleById($saleId);

        if (!$existingSale) {
            http_response_code(404);
            Messages::notFound('Sale');
            return;
        }

        $result = $this->service->deleteSale($saleId);

        if ($result) {
            http_response_code(200);
            Messages::actionSuccess('removed','Sale');
        } else {
            http_response_code(500);
            Messages::actionFailed('remove','Sale');
        }
    }
}

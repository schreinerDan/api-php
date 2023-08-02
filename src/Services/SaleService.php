<?php
namespace Services;

use Repositories\SaleRepository;
use Models\Sale;

class SaleService 
{
    private $repository;

    public function __construct(SaleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllSales()
    {
        return $this->repository->getAll();
    }

    public function getSaleById($id)
    {
        return $this->repository->getById($id);
    }

    public function createSale(Sale $sale)
    {
        return $this->repository->createSale($sale);
    }

    public function updateSale($id, Sale $sale)
    {
        return $this->repository->update($id, $sale);
    }

    public function deleteSale($id)
    {
        return $this->repository->delete($id);
    }
}

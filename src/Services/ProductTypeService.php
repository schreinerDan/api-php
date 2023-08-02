<?php
namespace Services;

use Repositories\ProductTypeRepository;
use Models\ProductType;

class ProductTypeService 
{
    private $repository;

    public function __construct(ProductTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProductTypes()
    {
        return $this->repository->getAll();
    }

    public function getProductTypeById($id)
    {
        return $this->repository->getById($id);
    }

    public function createProductType(ProductType $productType)
    {
        return $this->repository->createProductType($productType);
    }

    public function updateProductType($id, ProductType $product)
    {
        return $this->repository->update($id, $product);
    }

    public function deleteProductType($id)
    {
        return $this->repository->delete($id);
    }
}

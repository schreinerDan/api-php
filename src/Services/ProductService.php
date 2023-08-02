<?php
namespace Services;

use Repositories\ProductRepository;
use Models\Product;

class ProductService 
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProducts()
    {
        return $this->repository->getAll();
    }

    public function getProductById($id)
    {
        return $this->repository->getById($id);
    }

    public function createProduct(Product $product)
    {
        return $this->repository->createProduct($product);
    }

    public function updateProduct($id, Product $product)
    {
        return $this->repository->update($id, $product);
    }

    public function deleteProduct($id)
    {
        return $this->repository->delete($id);
    }
}

<?php

namespace Repositories;

use Core\PgsqlConnectionPool;
use Models\Product;


class ProductRepository extends Repository
{


    public function __construct(PgsqlConnectionPool $connectionPool)
    {
        parent::__construct($connectionPool);
        $this->table = "products";
    }
    public function createProduct(Product $data)
    {
        $dbi = $this->getPgsqlConnection();

        $query = "INSERT INTO products (barcode,
                                        name,
                                        type_id,
                                        price,
                                        stock_quantity,
                                        description,
                                        image)
                              VALUES   ('$data->barcode',
                                        '$data->name',
                                        $data->type_id,
                                        $data->price,
                                        $data->stock_quantity,
                                        '$data->description',
                                        '$data->image')";
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $result;
    }

}

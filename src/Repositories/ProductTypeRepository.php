<?php 
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Repositories;

use Core\PgsqlConnectionPool;
use Models\ProductType;
class ProductTypeRepository extends Repository {
    public function __construct(PgsqlConnectionPool $connectionPool) {
        parent::__construct($connectionPool);
        $this->table = "product_types";
    }



    public function createProductType(ProductType $data) {
        $dbi = $this->getPgsqlConnection();

        $query = "INSERT INTO product_types (
                                        name,
                                        percentage
                                        )
                              VALUES   (
                                        '$data->name',
                                        $data->percentage
                                        )";
        
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $result;
    }

    public function updateProductType($id, ProductType $productType) {
        $data = [
            'name' => $productType->name
        ];
        return $this->update($id, $data);
    }

}

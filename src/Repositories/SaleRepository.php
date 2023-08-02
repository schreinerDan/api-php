<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Repositories;

use Core\PgsqlConnectionPool;
use Models\Sale;

class SaleRepository extends Repository {
    public function __construct(PgsqlConnectionPool $connectionPool) {
        parent::__construct($connectionPool);
        $this->table = "sales";
    }
    public function createSale(Sale $data)
    {
        $dbi = $this->getPgsqlConnection();

        $query = "INSERT INTO sales (
                                        amount,
                                        amount_paid,
                                        difference,
                                        total_tax,
                                        products_solds,
                                        payment)
                              VALUES   ($data->amount,
                                        $data->amount_paid,
                                        $data->difference,
                                        $data->total_tax,
                                        '$data->products_solds',
                                        '$data->payment')";
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $result;
    }

   
}

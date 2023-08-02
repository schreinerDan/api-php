<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Models;
class Sale {
    private $id;
    private $amount;
    private $amount_paid;
    private $difference;
    private $total_tax;
    private $sale_date;
    private $products_solds;
    private $payment;
 
    public function __construct($data)
    {
        if (sizeof($data)>0) {
            $this->id = $data['id'] ?? null;
            $this->amount = $data['amount']  ?? null;
            $this->amount_paid = $data['amount_paid'] ?? null;
            $this->difference = $data['difference'] ?? null;
            $this->total_tax = $data['total_tax']  ?? 0;
            $this->sale_date = $data['sale_date'] ?? 0;
            $this->products_solds = $data['products_solds'] ?? null;
            $this->payment = $data['payment'] ?? null;
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function __get($name)
    {
        return $this->$name;
    }
  
}

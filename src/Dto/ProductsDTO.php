<?php 
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */

class ProductsDTO
{

    private $barcode;
    private $name;
    private $price;
    private $brand;
    private $description;
    private $image;

    public function __construct($data =null)
    {

        if($data !=null){
            $this->parseJson($data);
        }

    }
    
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    		
    private function parseJson($data){
        if($data){
            $this->barcode = array_key_exists('barcode')? $data['barcode']:null;
            $this->name = $data['name'];
            $this->price = $data['price'];
            $this->brand = $data['brand'];
            $this->description = $data['description'];
            $this->image = $data['image'];         
        }
    }

}
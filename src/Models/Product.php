<?php

namespace Models;

class Product
{
    private $id;
    private $barcode;
    private $name;
    private $type_id;
    private $price;
    private $stock_quantity;
    private $description;
    private $image;

    public function __construct($data)
    {
        if (sizeof($data)>0) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name']  ?? null;
            $this->barcode = $data['barcode'] ?? null;
            $this->type_id = $data['type_id'] ?? null;
            $this->price = $data['price']  ?? 0;
            $this->stock_quantity = (int)$data['stock_quantity'] ?? 0;
            $this->description = $data['description'] ?? null;
            $this->image = $data['image'] ?? null;
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

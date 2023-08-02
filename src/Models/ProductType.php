<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Models;

class ProductType {
    private $id;
    private $name;
    private $percentage;

    public function __construct($data)
    {
        if (sizeof($data)>0) {
            $this->id = $data['id']  ?? null;
            $this->name = $data['name']  ?? null;
            $this->percentage = $data['percentage']  ?? null;
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

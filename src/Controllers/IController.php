<?php 
namespace Controllers;
use Core\Messages;

interface IController{
    public function getById($param);
    public function getAll();
    public function create();
    public function update($param);
    public function delete($params);
}
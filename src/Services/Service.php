<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */

class Service 
{
    public $repository;
    public $requestMethod;
    public $method;
    public $param;
    public $defaultRequest=['getAll','getById','create','update','delete'];
    
    public function __construct($requestMethod, $method, $param)
    {
        $this->requestMethod = $requestMethod;
        $this->method = $method;
        $this->param = $param;
    }
    
    public function getById($id)
    {
        $result = $this->repository->getById($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getAll()
    {
        $result = $this->repository->getAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function create($data)
    {
        $result = $this->repository->create($data);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    public function update($id, $data)
    {
        $result = $this->repository->update($id, $data);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function delete($id)
    {
        $result = $this->repository->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    public function processDefaultRequest()
    {    
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->method == "getAll") {
                    $response = $this->getAll();
                }
                break;
            case 'POST':
                if ($this->method == "create") {
                    $response = $this->create($_REQUEST);
                }
                break;
            case 'PUT':
                if ($this->method == "update" && $this->param != null) {
                    $response = $this->update($this->param, $_REQUEST);
                }
                break;
            case 'DELETE':
                if ($this->method == "delete" && $this->param != null) {
                    $response = $this->delete($this->param);
                }
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    
    public function isDefaultRequest()
    {
        if ($this->method != null) {
            return in_array($this->method, $this->defaultRequest);
        }
        return false;
    }
    
    public function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}


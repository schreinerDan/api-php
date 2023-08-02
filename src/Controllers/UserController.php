<?php

namespace Controllers;
define('DATA','php://input');
use Services\UserService;
use Repositories\UserRepository;
use Models\User;
use Core\Router;
use Core\Messages;
use Core\PgsqlSingleton;

class UserController implements IController
{
    private $service;

    public function __construct()
    {
        $dbi = PgsqlSingleton::getInstance();
        $repository = new UserRepository($dbi);
        $repository->table = "users";
        $this->service = new UserService($repository);
    }
    /**
     * Get all users
     */
    public function getAll()
    {
        
        $users = $this->service->getAllUsers();
        echo json_encode($users);
    }

    /**
     * Get user by id
     */
    public function getById($params)
    {
        
        $userId = $params['id'];

        $existingUser = $this->service->getUserById($userId);
        if (!$existingUser) {
            http_response_code(404); 
            Messages::notFound('User');
            return;
        }

        echo json_encode($existingUser);
    }
   

    /**
     * Create a new user
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            Messages::methodNotAllowed();
            return;
        }

        $data = json_decode(file_get_contents(DATA), true);

        if (empty($data) || !isset($data['name']) || !isset($data['username'])) {
            http_response_code(400); 
            Messages::invalidRequestData();
            return;
        }

        $user = new User($data);
        $result = $this->service->createUser($user);
       
        if ($result) {
            http_response_code(201); 
            Messages::actionSuccess('created','User');
        } else {
            http_response_code(500); 
            Messages::actionFailed('create','User');
        }
    }

    /**
     * Update a user
     */
    public function update($params)
    {        
        $userId = $params['id'];

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405); 
            Messages::methodNotAllowed();
            return;
        }

        $data = json_decode(file_get_contents(DATA), true);
        
        if (empty($data)) {
            http_response_code(400); 
            Messages::invalidRequestData();
            return;
        }

        $existingUser = $this->service->getUserById($userId);
        
        if (!$existingUser) {
            http_response_code(404); 
            Messages::notFound('User');
            return;
        }

        $user = new User($data);
        
        $result = $this->service->updateUser($userId, $user);

        if ($result) {
            http_response_code(200); 
            Messages::actionSuccess('updated','User');
        } else {
            http_response_code(500); 
            Messages::actionFailed('update','User');
        }
    }

    /**
     * Remove a user 
     */
    public function delete($params)
    {
        $userId = $params['id'];
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            Messages::methodNotAllowed();
            return;
        }

        $existingUser = $this->service->getUserById($userId);

        if (!$existingUser) {
            http_response_code(404);
            Messages::notFound('User');
            return;
        }

        $result = $this->service->deleteUser($userId);

        if ($result) {
            http_response_code(200);
            Messages::actionSuccess('removed','User');
        } else {
            http_response_code(500);
            Messages::actionFailed('remove','User');
        }
    }
    
    /**
     * Login
     */
    public function login()
    {
        $data = json_decode(file_get_contents(DATA), true);
        if (empty($data) || !isset($data['username']) || !isset($data['password'])) {
            http_response_code(400); 
            Messages::invalidRequestData();
            return;
        }

        $user = $this->service->getUserByUsername($data['username']);

        if (!$user || ($data['password']  != $user->password)) {
            http_response_code(401); 
            Messages::actionFailed('Authentication','Login');
            return;
        }
        $secretKey = '123';
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            "iss" => "APIii",
            "aud" => "marter",
            "iat" => time(),
            "exp" => time() + 3600,
            "sub" => $user->id,
            "username" => $user->username
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        http_response_code(200); 
        echo json_encode(array("message"=>"success", "status"=>200, "token"=>$token,"user"=>$user));
    }


}

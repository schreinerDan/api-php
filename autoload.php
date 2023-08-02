<?php 

include_once "./src/Core/PgsqlSingleton.php" ;
include_once "./src/Core/PgsqlConnectionPool.php" ;
include_once "./src/Core/Router.php";
include_once "./src/Core/Messages.php";

include_once "./src/Controllers/IController.php";
include_once "./src/Controllers/ProductController.php";
include_once "./src/Controllers/ProductTypeController.php";
include_once "./src/Controllers/UserController.php";
include_once "./src/Controllers/SaleController.php";


include_once "./src/Services/Service.php";
include_once "./src/Services/ProductService.php";
include_once "./src/Services/ProductTypeService.php";
include_once "./src/Services/UserService.php";
include_once "./src/Services/SaleService.php";


include "./src/Repositories/Repository.php";
include "./src/Repositories/ProductRepository.php";
include "./src/Repositories/ProductTypeRepository.php";
include "./src/Repositories/UserRepository.php";
include "./src/Repositories/SaleRepository.php";


include "./src/Models/Product.php";
include "./src/Models/ProductType.php";
include "./src/Models/User.php";
include "./src/Models/Sale.php";


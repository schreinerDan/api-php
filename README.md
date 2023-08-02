API REST PHP 



### Installation 

git clone https://github.com/schreinerDan/api-php.git

edit file .htaccess 
```bash
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```
start server :

```bash
php -S localhost:8080   
```

### Database configuration 
in file  src/Core/PgsqlConnectionPool.php
...
    private $host = '131.0.96.82'; //REMOTE SERVER
    private $user = 'postgres';
    private $password = 'entra@1234';
    private $database = 'postgres';
....


### Live Demo

http://131.0.96.82/




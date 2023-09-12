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




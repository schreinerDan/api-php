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


### Example of making API calls 

It's convenient to use singleton class `PosterApi`. 
All you need to is initialize class with user credentials and then you can call Poster API methods anywhere in your project   



# Docker + Symfony 4 RESTful API with JWT token

This project is all you need to start simply and fastly new RESTful APIs using Symfony 4. This stack uses Docker easy maintenance cycle for your REST API.


### Installing and starting your RESTful API

-   Implement assignment using:
    -   Language: **PHP**
    -   Framework: **Symfony**
    -   Infrastructure : **Docker**

1) Just clone this repository with:
```
git clone https://github.com/kanojiyadhaval/symfony-rest-api-demo.git
```

2) Go to your root folder and run below command to spin-up application:
```
docker-compose up -d
```

3) Execute the following command install composer and seed the database:
```
docker-compose exec php-fpm composer install
docker-compose exec php-fpm php bin/console doctrine:schema:create
```

4) Access below URL to access application
```
http://localhost:8000
```

## API Documentation (JWT)
The initial RESTful API code provided by this bundle is an example of a JWT Authentication approach with Symfony 4, 
below are listed all initial routes provided:  

`POST > http://localhost:8080/register` (json body example):  
```JSON
{
	"username":"www",
	"password":"dk12345",
	"email":"dk@www.com",
	"author_pseudonym": "www"
}
```

`POST > http://localhost:8080/login_check` (json body example):  
```JSON
{
	"username": "www",
	"password": "dk12345"
}
```

`GET > http://localhost:8080/api` (Authorization Header is required for all protected routes):  
```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Ik1heWtvbm4iLCJpYXQiOjE1MTYyMzkwMjJ9.b7rMHdFlAixTQA6DzLoHIjw3MrRtkbm3tuUr_zgXhmE
```

Brief documention can be found below :
[API Documentation](https://documenter.getpostman.com/view/11432514/SzmmWFCv?version=latest#e82b0938-722d-4161-b7bd-a69afd54b21d)

(Postman collection json file added into root folder of this repo. it can be use for API test cases.)
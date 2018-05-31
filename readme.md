## Laravel 5.6 and Docker

* Laravel 5.6
* Docker 

##Installation

Docker up 

    $ docker-compose up 
    $ docker-compose up --build 
    

##In Browser 

    http://0.0.0.0:8080
    
## Docker Commands

    $ docker-compose exec app php artisan key:generate
    $ docker-compose exec app php artisan optimize
    $ docker-compose exec app php artisan migrate
    $ docker-compose exec app php artisan db:seed
    $ docker-compose exec app php artisan migrate --seed
    $ docker-compose exec app php artisan make:controller MyController
    
Tip: create an alias like `phpd` that removes the need to type the full command, eg: `phpd artisan migrate --seed`

##Elastic Search 

Download from docker hub

    $ docker pull dockerfile/elasticsearch
    
Usage

    $ docker run -d -p 9200:9200 -p 9300:9300 dockerfile/elasticsearch
    
Output 

    http://<host>:9200

## Contributor

[Selim Reza](http://www.SelimReza.com) 



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



## References

1. [Laravel + Docker Part 1](https://medium.com/@shakyShane/laravel-docker-part-1-setup-for-development-e3daaefaf3c)
2. [Laravel + Docker Part 2](https://medium.com/@shakyShane/laravel-docker-part-2-preparing-for-production-9c6a024e9797)
3. [Docker configuration](https://hackernoon.com/stop-deploying-laravel-manually-steal-this-docker-configuration-instead-da9ecf24cd2e)

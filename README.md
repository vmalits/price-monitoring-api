# Currency converter

## Usage

```
$ git clone https://github.com/vmalits/price-monitoring-api.git
```

```
$ cd price-monitoring-api/
```

```
$ cp .env.example .env
```

```
$ git submodule update --init --recursive
```

```
$ cp .env-laradock laradock/.env
```

```
$ ./run.sh 
```

```
$ ./dc.sh
```

```
$ php artisan key:generate
```

```
$ composer install
```

## Info

``` $ ./run.sh ```  Command runs docker containers

``` $ ./stop.sh ```  Command stops docker containers

``` $ ./dc.sh ```  Command to go to the container

Project running at address ```http://localhost``` 

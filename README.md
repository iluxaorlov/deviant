# The Deviant Framework

## Установка фреймворка
Рекомендую воспользоваться [Composer](https://getcomposer.org/) для установки:

```
$ composer require iluxaorlov/deviant
```

## Начало работы
Создаем файл `public/index.php` с базовым содержимым:

```php
<?php

use Deviant\Component\Response;
use Deviant\Component\Request;

require_once __DIR__ . '/../vendor/autoload.php';

// Инициализация приложения
$app = new Deviant\App();

// Настройка роутинга
$app->get('/', function(Response $response, Request $request, array $args) {
    return $response->withBody('Hello World');
});

$app->get('/hello/{name}', function(Response $response, Request $request, array $args) {
    $name = $args['name'];
    $response->withBody('Hello, ' . $name);
    return $response;
});

// Запуск приложения
$app->run();
```

Проверяем наше приложение при помощи встроенного сервера PHP:

```
$ php -S localhost:8000 -t public
```

Переходим по адресу http://localhost:8000/ и видим надпись "Hello World"

[Composer]: https://getcomposer.org/
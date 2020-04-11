SaveTime Atol SDK (Platron Atol SDK Fork)
===============
## Установка

Добавляем репозиторий в composer.json
```$json
...
 "repositories": [
        {
            "type": "git",
            "url": "git@gitlab-01.svt:savetime/module/atol.git"
        }
    ],
...
```

В консоли выполняем
<pre><code>composer require savetime/atol-sdk-api-v4</pre></code>

## Тесты
Для работы тестов необходим PHPUnit, для его установки необходимо выполнить команду
```
composer require phpunit/phpunit
```
Для того, чтобы запустить интеграционные тесты нужно скопировать файл tests/integration/MerchantSettingsSample.php удалив 
из названия Sample и вставив настройки магазина. После выполнить команду из корня проекта
```
vendor/bin/phpunit vendor/payprocessing/atol-online/tests/integration
```

## Примеры использования

Можно найти в интеграционных тестах tests/integration

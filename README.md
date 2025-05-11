<h1>API Task Concorde</h1>

<h2>!!!Правки которые необходимо внести для корректной регистрации и авторизации нового приложения!!!</h2>

____
Регистрация нового приложения будет происходить с помощью человека, который настраивает новый сенсор или
SPA-приложение.

В приложении будет реализована возможность зарегистрировать новый сенсор/SPA, для регистрации 
будет необходимо передать пароль хранящийся в БД, это пароль будет перегироваться с указанной переодичностью.
Этот функционал необходим для получения токена OAuth.

После регистрации устройству отдаётся токен, с помощью, которого, оно сможет авторизовываться в приложении и получать/закладывать данные.


Принцип регистрации нового устройства.

Человек ответственный за настройку сенсора/SPA-приложения, получает пароль, далее он настраивает окружение и при первом запросе приложения,
должен отправить пост запрос с именем приложения и паролем (полученный ранее), в случае успеха, приложение вернёт токен, необходимый для дальнейшей авторизации.
После регистрации, устройство должно будет отправлять в запросе полученный токен.

<ul>
    <li>
        Релизовываем весь функционал перегенерации пароля по заданному периоду
    </li>
    <li>
        В роуте определяем, путь до регистратора. (POST /register)
    </li>
    <li>
        Определяем контроллер регистратора
    </li>
    <li>
        Определяем логику регистратора
    </li>
    <li>
        Регистрируем пакет Laravel Sanctum и через него проверяем, поступающие токены
    </li>
</ul>

___

Приложение позволяет добавить значение для конкретного сенсра и получить спиоск
изменений параметра.

<h2>Установка</h2>

1. Установите PHP
   ```bash
   apt-get install php8.4
   ```
2. Установите composer
    ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    sudo mv composer.phar /usr/local/bin/composer
    ```
3. Если используется Linux установите необходимые библиотеки PHP. https://laravel.su/docs/11.x/deployment#trebovaniia-k-serveru<br><br>
4. Установите postgresql
    ```bash
    apt install postgresql postgresql-contrib -y
    ```
5. Клонируйте проект:<br>
    ```bash
    git clone https://github.com/yourusername/sensor-api.git
    cd sensor-api
    ```
6. Скопируйте .env.example, установите доступы до базы и смените информацию о приложении
    ```bash
   cp .env.example .env 
   ```
7. Сгенерируйте ключ приложения
    ```bash
    php artisan key:generate
    ```
8. Запустите миграции
    ```bash
    php artisan migrate
    ```
9. Запустите приложение
   ```bash
   php artisan serve
   ```
   
<h2>Список доступных методов</h2>

<pre>
<strong>Установить измерение для датчика</strong>
<strong>GET: </strong><a>/api/</a>
<strong>Параметры запроса:</strong>
    1. <strong>sensor</strong> - Ид датчика из БД (Обязательный параметр)
<strong>Тело запроса: </strong><code>имя_параметра = значение</code>

<pre>
<h4>Пример запроса:</h4>
<strong>URL:</strong> <a>http://backend.ru/api/?sensor=1</a>
<strong>Тело запроса:</strong> T=20
</pre>
</pre>

<pre>
<strong>Получить измерения датчика/датчиков</strong>
<strong>GET: </strong><a>/api/get/</a>
<strong>Параметры запроса:</strong>
    1. <strong>sensor</strong> - Ид датчика из БД. (Обязательный параметр)
        Этот метод позволяет передать ИД сенсора в следующих видах:
            sensor=id                   - получить данные по конретному датчику.
            sensor[]=id_1&sensor[]=id_2 - получить данные по нескольким датчикам
            sensor=all                  - получить данные сразу по всем датчикам
    2. <strong>begin</strong>  - Дата в формате timestamp или <strong>y-m-d H:i:s</strong>
    3. <strong>end</strong>    - Дата в формате timestamp или <strong>y-m-d H:i:s</strong>
<pre>
<h4>Примеры запросов:</h4>
    1. <strong>URL:</strong> <a>http://backend.ru/api/get/?sensor=1&begin=2025-03-23 09:00:00&end=2025-03-23 19:00:00</a>
    2. <strong>URL:</strong> <a>http://backend.ru/api/get/?sensor=1&begin=1742695200&end=1742731200</a>
    3. <strong>URL:</strong> <a>http://backend.ru/api/get/?sensor[]=1&sensor[]=2&begin=1742695200&end=1742731200</a>
    4. <strong>URL:</strong> <a>http://backend.ru/api/get/?sensor=all&begin=1742695200&end=1742731200</a>
</pre>
</pre>

<h2>Тестирование</h2>
В проекте реализованы тесты, запустите их перед началом работы, чтобы убедиться, что проект полностью рабочий.

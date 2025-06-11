
## 🧾 Что требуется для запуска:
1. PHP >= 8.4
2. PHP расширения (включить в `php.ini`)
   - `extension=pdo_mysql`
   - `extension=gd`
3. MySQL Server 8+(я использовал `MySQL 8.0 Server Community Edition`)
4. Composer

| ⚠️ Веб-сервер не нужен (всё запускается через встроенный сервер `php -S`)  
| ⚠️ Чтобы запустить на `Windows` без ide, то нужно использовать `Windows Power Shell`.  

## 📦 Как установить и запустить:

1. Что должно быть включено в php.ini

В файле `php.ini` (можно найти путь через `php --ini`) обязательно должны быть включены:
```ini
extension=pdo_mysql
extension=gd
```

2. Установка зависимостей.  
   Откройте терминал в корне проекта и выполните:
```bash
   composer install
```

3.  Подготовьте изображения

Скопируйте в папку `gallery/` несколько `.jpg` изображений, например:
```
gallery/
├── test1.jpg
├── test2.jpg
└── test3.jpg
```

4.  Настройка базы данных

- Убедитесь, что MySQL запущен (я использовал `MySQL 8.0 Server Community Edition`).
- Измените параметры подключения к БД в `src/Config.php`:
```php
public static string $host = "ваш_хост"; //Например: localhost
public static string $dbname = "ваша_бд"; //Например: gallery
public const string DB_USER = 'ваш_пользователь'; //Например: Admin
public const string DB_PASSWORD = 'ваш_пароль'; //Например: secret
```

5. Если БД не создана, то её можно создать запустив скрипт в корневой папке проекта:
```bash
   php create_db.php 
```  
P.S. - Имя у БД будет то, которое задано в `$dbname` в файле конфигурации `src/Config.php`


6. Запуск встроенного PHP-сервера  
Из корня проекта выполните команду:
```bash
   php -S localhost:8000 -t public
```  
Затем откройте в браузере:
```bash
   http://localhost:8000/demo.php
```  
- В браузере вы увидите сетку из миниатюр, например: 

- При клике на изображение будет открыта его увеличенная версия.  
- Если кэш картинки отсутствует, то он будет автоматически создан в папке `cache/`
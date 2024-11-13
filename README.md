# Team Management System

## Описание проекта
Team Management System — это приложение для управления проектами и разработчиками, разработанное в рамках
[тестового задания](https://docs.google.com/document/d/1YMxzZTCKNVtIR-2Xxw_AU6rKJ5FHxLZtEIQHw71lUJk/edit?tab=t.0). Проект позволяет создавать, редактировать и удалять разработчиков и проекты, а также управлять распределением разработчиков по проектам.

## Требования
- **PHP** версии 8.3
- **MySQL** версии 8.0
- **Symfony** версии 7.1.3
- **Composer** версии 2.7.8

## Установка

### 1. Клонируйте репозиторий:

```bash
git clone https://github.com/Andrey-Yurchuk/team-management-system.git
```
### 2. Перейдите в директорию проекта:

```bash
cd team-management-system
```
### 3. Установите зависимости с помощью Composer:

```bash
composer install
```
### 4. Настройте файл окружения:

В корне проекта вы найдете файл .env.example, который содержит пример настройки переменных окружения для проекта. 
Скопируйте его в файл .env:

```bash
cp .env.example .env
```
Откройте файл .env и отредактируйте его в соответствии с вашим окружением. Важные переменные для настройки:

```bash
APP_ENV=dev
APP_SECRET=<your-generated-app-secret>
DATABASE_URL="mysql://username:password@localhost:3306/database_name"
```
### 5. Генерация APP_SECRET:

Вы можете сгенерировать `APP_SECRET` с помощью следующей команды:

```bash
php bin/console secrets:generate-keys
```

### 6. Настройка подключения к базе данных:

В переменной `DATABASE_URL` укажите параметры подключения к вашей базе данных. Формат строки подключения для MySQL:

```bash
DATABASE_URL="mysql://username:password@localhost:3306/database_name"
```
Замените username, password, localhost и database_name на соответствующие значения для вашей базы данных.

### 7.Выполнение миграций:

После настройки файла окружения, выполните миграции для создания необходимых таблиц в базе данных:

```bash
php bin/console doctrine:migrations:migrate
```

### 8.Запуск проекта:

Для запуска проекта используйте встроенный сервер PHP:

```bash
php -S 127.0.0.1:8000 -t public
```

## Функционал

### Управление разработчиками

Перейдите на страницу списка разработчиков по адресу:
http://127.0.0.1:8000/developers

- **Создать нового разработчика:**  нажмите кнопку "Create New Developer"
- **Редактировать разработчика:** нажмите "Edit" напротив нужного разработчика
- **Удалить разработчика:** нажмите "Delete"

![developer_list Screenshot](images/developer_list.png)

### Управление проектами

Перейдите на страницу списка проектов по адресу:
http://127.0.0.1:8000/projects

- **Создать новый проект:**  нажмите кнопку "Create New Project"
- **Редактировать проект:** нажмите "Edit" напротив нужного проекта
- **Удалить проект:** нажмите "Delete"

![edit_project Screenshot](images/edit_project.png)

_На скриншотах выше показан пользовательский интерфейс приложения Team Management System_

P.S. SQL-запросы по последнему 5 пункту задания находятся в каталоге sql_query в файле query.sql
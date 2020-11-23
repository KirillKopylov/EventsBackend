# EventsBackend
## Описание
Небольшой проект для управления мероприятиями. Имеется возможность создавать, редактировать, просматривать,
удалять мероприятия и пользователей. При создании пользователя, ему на почту отправляется письмо.
## Инструкция по развёртыванию проекта
- Клонируйте репозиторий и перейдите к нему в директорию;
- выполните установку зависимостей:
```
composer install
```
- скопируйте конфиг:
```
cp ./.env.example ./.env
```
- в **.env** укажите параметры подключения к базе данных и данные для работы почты. Чтобы письма отправлялись в лог,
присвойте параметру **MAIL_MAILER** значение **log**;
- выполните миграции:
```
php artisan migrate
```
- запустите тесты:
```
php artisan test
```
- запустите обработчик очереди сообщений:
```
php artisan queue:work
```
Выбор сервера остаётся за вами. Если с сервером лень заморачиваться, всегда можно использовать
```
php artisan serve
```
## Описание API
### Общий формат внутренней ошибки сервера (например, при работе с базой данных):
```json
{
    "error": true,
    "message": "<Описание ошибки>"
}
```
с кодом ответа 500.
### Общий формат ошибки валидации (в зависимости от полей):
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "<Описание ошибки>"
        ],
        "date": [
            "<Описание ошибки>"
        ],
        "city": [
            "<Описание ошибки>"
        ]
    }
}
```
с кодом ответа 422

<hr>

## Управление мероприятиями
### Создание мероприятия
#### Запрос
**PUT** /api/events/create-event
<br>

Параметр | Описание | Дополнительно | Пример | Обязательный?
---------|----------|---------------|--------|--------------
title | Название | До 255 символов | Проверочное событие | +
date | Дата проведения | Дата в формате yyyy-mm-dd mm:hh:ss | 2020-11-23 08:25:13 | +
city | Город | До 200 символов | Нижний Новгород | +

#### Пример ответа:

```json
{
    "error": false,
    "response": {
        "message": "Event successfully created",
        "id": 1
    }
}
```
с кодом ответа 200.

<hr>

### Получение мероприятия
#### Запрос 
**GET** /api/events/get-event/{id}
<br>
Вместо {id} подставляется id мероприятия, по которому нужно получить информацию.
Например, /api/events/get-event/1
#### Пример ответа:

```json
{
    "error": false,
    "event": {
        "id": 1,
        "title": "Проверочное событие",
        "date": "2020-11-23 08:25:13",
        "city": "Нижний Новгород",
        "created_at": "2020-11-23T06:18:09.000000Z",
        "updated_at": "2020-11-23T06:18:09.000000Z"
    }
}
```
с кодом ответа 200
##### в случае, когда мероприятие с переданным id не найдено:
```json
{
    "error": true,
    "message": "Event with provided id does not exists"
}
```
с кодом ответа 404.

<hr>

### Редактирование мероприятия
#### Запрос
**PATCH** /api/events/update-event

Параметр | Описание | Дополнительно | Пример | Обязательный?
---------|----------|---------------|--------|--------------
id | id мероприятия | Должно существовать | 1 | +
title | Название | До 255 символов | Проверочное событие | +
date | Дата проведения | Дата в формате yyyy-mm-dd mm:hh:ss | 2020-11-23 08:25:13 | +
city | Город | До 200 символов | Нижний Новгород | +
#### Пример ответа:

```json
{
    "error": false,
    "message": "Event successfully updated"
}
```
с кодом ответа 200.

<hr>

### Получение списка всех мероприятий
#### Запрос
**GET** /api/events/get-events
#### Пример ответа:
```json
{
    "error": false,
    "events": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "Изменил название",
                "date": "2021-01-12 16:30:45",
                "city": "Donetsk",
                "created_at": "2020-11-23T06:18:09.000000Z",
                "updated_at": "2020-11-23T06:34:39.000000Z"
            },
            {
                "id": 2,
                "title": "Customizable zeroadministration firmware",
                "date": "2020-08-30 02:46:37",
                "city": "North Kimberly",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 3,
                "title": "Realigned human-resource infrastructure",
                "date": "2020-09-10 13:45:50",
                "city": "Archibaldfurt",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 4,
                "title": "Expanded 6thgeneration data-warehouse",
                "date": "2020-08-13 21:51:39",
                "city": "Port Ovaton",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 5,
                "title": "Total tertiary internetsolution",
                "date": "2020-02-12 00:54:32",
                "city": "New Alishatown",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            }
        ],
        "first_page_url": "http://events/api/events/get-events?page=1",
        "from": 1,
        "last_page": 7,
        "last_page_url": "http://events/api/events/get-events?page=7",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": "http://events/api/events/get-events?page=2",
                "label": 2,
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=3",
                "label": 3,
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=4",
                "label": 4,
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=5",
                "label": 5,
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=6",
                "label": 6,
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=7",
                "label": 7,
                "active": false
            },
            {
                "url": "http://events/api/events/get-events?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://events/api/events/get-events?page=2",
        "path": "http://events/api/events/get-events",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 101
    }
}
```
с кодом ответа 200
<br>
Чтобы не отдавать скопом весь список мероприятий, была добавлена встроенная во фреймворк пагинация.
Для перехода на следующую страницу, нужно добавить параметр page, последовательно его инкрементируя.
Например, чтобы получить следущие элементы списка, нужно перейти на /api/events/get-events?page=2
Последняя страница указана в поле **last_page**.

<hr>

### Получение участников мероприятия
#### Запрос
**GET** /api/events/get-event-members/{id}
#### Пример ответа:
```json
{
    "error": false,
    "members": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "event_id": 2,
                "first_name": "Daphne",
                "last_name": "Reichert",
                "email": "eulah.lindgren@example.org",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 2,
                "event_id": 2,
                "first_name": "Elody",
                "last_name": "Bednar",
                "email": "alda.kerluke@example.org",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 3,
                "event_id": 2,
                "first_name": "Jazlyn",
                "last_name": "Kuhic",
                "email": "lhyatt@example.net",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 4,
                "event_id": 2,
                "first_name": "Kayli",
                "last_name": "Abbott",
                "email": "harvey.roderick@example.net",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            }
        ],
        "first_page_url": "http://events/api/events/get-event-members/2?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://events/api/events/get-event-members/2?page=2",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://events/api/events/get-event-members/2?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": "http://events/api/events/get-event-members/2?page=2",
                "label": 2,
                "active": false
            },
            {
                "url": "http://events/api/events/get-event-members/2?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://events/api/events/get-event-members/2?page=2",
        "path": "http://events/api/events/get-event-members/2",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 30
    }
}
```
с кодом ответа 200

<hr>

### Удаление мероприятия
##### При удалении события, связанные с ним участники тоже будут удалены.
#### Запрос
**DELETE** /api/events/remove-event/{id}
#### Пример ответа:
```json
{
    "error": false,
    "message": "Event successfully deleted"
}
```
со статусом 200.
#### Если не удалось найти мероприятие с переданным id:
```json
{
    "error": true,
    "message": "Event with provided id does not exists"
}
```
с кодом ответа 404.

<hr>

## Управление участниками мероприятия

### Создание участника мероприятия
#### Запрос
**PUT** /api/users/create-user

Параметр | Описание | Дополнительно | Пример | Обязательный?
---------|----------|---------------|--------|--------------
event_id | id мероприятия | Должно существовать | 2 | +
first_name | Имя | Максимум 30 символов | John | +
last_name | Фамилия | Максимум 30 символов | Doe | +
email | Эл. почта | максимум 255 символов, должен быть валидным адресом эл. почты, уникальный | example@example.com | +

#### Пример ответа:
```json
{
    "error": false,
    "response": {
        "message": "User successfully created",
        "id": 3001
    }
}
```
с кодом ответа 200

<hr>

### Получение участника мероприятия
#### Запрос
**GET** /api/users/get-user/{id}
#### Пример ответа:
```json
{
    "error": false,
    "user": {
        "id": 3001,
        "event_id": 2,
        "first_name": "John",
        "last_name": "Joe",
        "email": "example@example.com",
        "created_at": "2020-11-23T07:17:38.000000Z",
        "updated_at": "2020-11-23T07:17:38.000000Z"
    }
}
```
с кодом ответа 200
#### в случае, когда участник мероприятия с переданным id не найден:
```json
{
    "error": true,
    "message": "User with provided id does not exists"
}
```
с кодом ответа 404.

<hr>

### Обновление участника мероприятия
#### Запрос
**PATCH** /api/users/update-user

Параметр | Описание | Дополнительно | Пример | Обязательный?
---------|----------|---------------|--------|--------------
id | id пользователя | Должно существовать | 3001 | +
event_id | id мероприятия | Должно существовать | 2 | +
first_name | Имя | Максимум 30 символов | John | +
last_name | Фамилия | Максимум 30 символов | Doe | +
email | Эл. почта | максимум 255 символов, должен быть валидным адресом эл. почты, уникальный | example@example.com | +

#### Пример ответа:
```json
{
    "error": false,
    "message": "User successfully updated"
}
```
с кодом ответа 200.

<hr>

### Получение всех участников мероприятий
#### Запрос
**GET** /api/users/get-users
#### Пример ответа:
```json
{
    "error": false,
    "users": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "event_id": 2,
                "first_name": "Daphne",
                "last_name": "Reichert",
                "email": "eulah.lindgren@example.org",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 2,
                "event_id": 2,
                "first_name": "Elody",
                "last_name": "Bednar",
                "email": "alda.kerluke@example.org",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 3,
                "event_id": 2,
                "first_name": "Jazlyn",
                "last_name": "Kuhic",
                "email": "lhyatt@example.net",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 4,
                "event_id": 2,
                "first_name": "Kayli",
                "last_name": "Abbott",
                "email": "harvey.roderick@example.net",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            },
            {
                "id": 5,
                "event_id": 2,
                "first_name": "Bette",
                "last_name": "Goodwin",
                "email": "gulgowski.hilario@example.org",
                "created_at": "2020-11-23T06:40:14.000000Z",
                "updated_at": "2020-11-23T06:40:14.000000Z"
            }
        ],
        "first_page_url": "http://events/api/users/get-users?page=1",
        "from": 1,
        "last_page": 199,
        "last_page_url": "http://events/api/users/get-users?page=199",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": "http://events/api/users/get-users?page=2",
                "label": 2,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=3",
                "label": 3,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=4",
                "label": 4,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=5",
                "label": 5,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=6",
                "label": 6,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=7",
                "label": 7,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=8",
                "label": 8,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=9",
                "label": 9,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=10",
                "label": 10,
                "active": false
            },
            {
                "url": null,
                "label": "...",
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=198",
                "label": 198,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=199",
                "label": 199,
                "active": false
            },
            {
                "url": "http://events/api/users/get-users?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://events/api/users/get-users?page=2",
        "path": "http://events/api/users/get-users",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 2971
    }
}
```
с кодом ответа 200.

<hr>

### Удаление участника мероприятия
#### Запрос
**DELETE** /api/users/remove-user/{id}
#### Пример ответа:
```json
{
    "error": false,
    "message": "User successfully deleted"
}
```
с кодом ответа 200
#### Если пользователь с переданным id не найден:
```json
{
    "error": true,
    "message": "User with provided id does not exists"
}
```
с кодом ответа 404.

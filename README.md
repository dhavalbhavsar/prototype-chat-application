### Prototype Of Messaging Chat Application

Using mysql and laravel version(8.x) to create chat messages application.

### Setup

---

1. Run `composer install`
2. Copy `.env.example` to `.env` Example for linux users : `cp .env.example .env`
3. Set valid database credentials of env variables `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`
4. Run `php artisan key:generate` to generate application key
5. Run `php artisan migrate`
6. Run `php artisan db:seed`
7. Run `vendor/bin/phpunit` 

Thats it... Run the command `php artisan serve` and cheers


### Chat Application (API)

1. Create group
2. Add user to group
3. Remove user to group
4. Send message to group
5. List of message


| Method  | Route | Parameters | 
| ------------- | ------------- | ------------- |
| POST  | api/group/create/{user_id}  | name - string |
| POST  | api/group/add-user/{group_id}/{user_id}  | user_id - integer (To add user to group) |
| POST  | api/group/remove-user/{group_id}/{user_id}  | user_id - integer (To remove user to group) |
| POST  | api/message/create/{group_id}/{user_id}  | message - string |
| GET  | api/message/list/{group_id}/{user_id}/{last_message_id?}  |  |

Note:-

1) user_id = It's only made simple but better to use login via API then we can remove this.
2) last_message_id = Which is to maintain and get the result of the list after that. It's an optional parameter. If it will not pass then return all messages.
# shatterproof-api

## Required components
* PHP 7.4.2
* Composer 1.9.3
* MySQL Server 8.0 (if using)

## Dev setup
1. Install required components.
2. Set up MySQL server if necessary.
3. Clone repository.
4. In root directory, run `composer install`.
5. Modify `DATABASE_URL` in `.env` file to URL of MySQL server.
6. For new database: follow database steps below
8. To start server, run `symfony server:start`.

## Database setup
1. Create migration by running `bin/console make:migration` command.
2. Migrate changes to database by running `bin/console doctrine:migrations:migrate` command.
3. If wanted, load fake data by running `bin/console doctrine:fixtures:load` command.

## User guide
This API server currently supports create, retrieve, update, and delete operations of a pledge user entity.

* ### Retreive user information
> `GET /users/<userId>`
>> Returns
>>```javascript
>>{
>>   userId: integer,
>>   firstName: string,
>>   lastName: string,
>>   email: string, // is unique
>>   zipcode: string,
>>   organization: string, // can be null
>>   newsletterSub: boolean,
>>   shareOnMedia: boolean,
>>   pledged: boolean,
>>   customPledgeLink: string // provided by Drupal lifecycle management of Custom Pledge
>>}
>>```
>> Invalid user id
>>```
>> No user found for id <userId> ! (500 Internal Server Error)
>>```

* ### Create new user
> `POST /users/add`
>> Sends JSON body
>>```javascript
>>{
>>   firstName: string,
>>   lastName: string,
>>   email: string,
>>   zipcode: string,
>>   organization: string, // can be null
>>   newsletterSub: boolean,
>>   shareOnMedia: boolean,
>>   pledged: boolean,
>>   customPledgeLink: string // provided by Drupal lifecycle management of Custom Pledge
>>}
>>```
>> Returns
>>```javascript
>>{
>>   status: "User created!",
>>   userId: integer
>>}
>>```
>> Duplicate email error returns
>>```
>> User with id <userId> already exists for email <email> ! (500 Internal Server Error)
>>```

* ### Update existing user
> `POST /users/update`
>> Sends JSON body
>>```javascript
>>{
>>   userId: integer,
>>   firstName: string,
>>   lastName: string,
>>   email: string,
>>   zipcode: string,
>>   organization: string, // can be empty string
>>   newsletterSub: boolean,
>>   shareOnMedia: boolean,
>>   pledged: boolean,
>>   customPledgeLink: string // provided by Drupal lifecycle management of Custom Pledge
>>}
>>```
>> Returns
>>```javascript
>>{
>>   status: "Updated user #"
>>}
>>```
>> Invalid user id
>>```
>> No user found for id <userId> ! (500 Internal Server Error)
>>```
>> Duplicate email error returns
>>```
>> User with id <userId> already exists for email <email> ! (500 Internal Server Error)
>>```

* ### Delete existing user
> `POST /users/delete`
>> Sends JSON body
>>```javascript
>>{
>>   userId: integer,
>>}
>>```
>> Returns
>>```javascript
>>{
>>   status: "Deleted user #"
>>}
>>```
>> Invalid user id
>>```
>> No user found for id <userId> ! (500 Internal Server Error)
>>```
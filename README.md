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
7. Modify `sender_email` and `receiver_email` in `config/services.yaml` to email addresses to send and receive messages from.
8. Modify `MAILER_URL` in `.env` file to url of email server and include `USERNAME` and `PASSWORD` of sender email.
9. To start server, run `symfony server:start`.

## Database setup
1. Create migration by running `bin/console make:migration` command.
2. Migrate changes to database by running `bin/console doctrine:migrations:migrate` command.
3. If wanted, load fake data by running `bin/console doctrine:fixtures:load` command.

## User guide
This API server currently supports create, retrieve, update, and delete operations of a pledge user entity.

### /users

* #### Retreive user information
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
>>   pledged: boolean,
>>   customPledgeLink: string // provided by Drupal lifecycle management of Custom Pledge
>>}
>>```
>> Invalid user id
>>```
>> No user found for id <userId> ! (500 Internal Server Error)
>>```

* #### Create new user
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
>>   pledged: boolean,
>>   customPledge: string
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

* #### Update existing user
> `POST /users/{userId}/update`
>> Sends JSON body
>>```javascript
>>{
>>   firstName: string,
>>   lastName: string,
>>   email: string,
>>   zipcode: string,
>>   organization: string, // can be empty string
>>   newsletterSub: boolean,
>>   pledged: boolean
>>}
>>```
>> Returns
>>```javascript
>>{
>>   status: "Updated user #!"
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

* #### Delete existing user
> `GET /users/{userId}/delete`
>> Returns
>>```javascript
>>{
>>   status: "Deleted user #!"
>>}
>>```
>> Invalid user id
>>```
>> No user found for id <userId> ! (500 Internal Server Error)
>>```

### /pledges
* #### Retreive all approved and sharable pledges
> `GET /pledges`
>> Returns
>>```javascript
>>[
>>  {
>>     pledgeId: integer,
>>     firstName: string,
>>     lastName: string,
>>     likeCount: integer,
>>     pledgeBody: string
>>  }
>>  ...more {}
>>]
>>```

* #### Retreive all pledges
> `GET /pledges/all`
>> Returns
>>```javascript
>>[
>>  {
>>     pledgeId: integer,
>>     firstName: string,
>>     lastName: string,
>>     likeCount: integer,
>>     pledgeBody: string
>>  }
>>  ...more {}
>>]
>>```

* #### Retreive pledge information
> `GET /pledges/<pledgeId>`
>> Returns
>>```javascript
>>{
>>   pledgeId: integer,
>>   firstName: string,
>>   lastName: string,
>>   likeCount: integer,
>>   pledgeBody: string,
>>   approved: boolean
>>}
>>```

* #### Update pledge information
> `POST /pledges/<pledgeId>/update`
>> Sends JSON body
>>```javascript
>>{
>>   pledgeId: integer,
>>   firstName: string,
>>   lastName: string,
>>   likeCount: integer,
>>   pledgeBody: string,
>>   approved: boolean
>>}
>>```
>> Returns
>>```javascript
>>{
>>   status: "Updated pledge #!"
>>}
>>```

* #### Delete pledge information
> `GET /pledges/<pledgeId>/delete`
>> Returns
>>```javascript
>>{
>>   status: "Deleted pledge #!"
>>}
>>```

* ### Approve pledge
> `GET /pledges/<pledgeId>/approve`
>> Returns
>>```javascript
>>{
>>   status: "Approved pledge #!"
>>}
>>```

* ### Increment pledge like count
> `GET /pledges/<pledgeId>/like`
>> Returns
>>```javascript
>>{
>>   status: "Pledge # like count increamented!",
>>   newCount: #
>>}
>>```

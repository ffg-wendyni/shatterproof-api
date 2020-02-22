# create skeleton project for rest api
composer create-project symfony/website-skeleton shatterproof-api
# view server on 127.0.0.1:8000
symfony server:start

# bundles for orm
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
# change DB URL params in .env file after

# create entity
# bin/console make:entity entity_name
# commands to make the db change
bin/console make:migration
bin/console doctrine:migrations:migrate

# fake data https://github.com/fzaninotto/Faker#fakerprovideren_usphonenumber
composer require --dev orm-fixtures
composer req fzaninotto/faker
composer req symfony/var-dumper
# load it
bin/console doctrine:fixtures:load

composer require annotations

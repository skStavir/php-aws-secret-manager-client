# php-aws-secret-manager-client
AWS secret manager client for php

## setup
create a secret in AWS secret manager
create a role that can read secrets .Configure the access key & secret key of the user in the code

## run the code
### composer install
### php -S localhost:8000 
### open browser and access http://localhost:8000/AwsSecretManagerClient.php
### you will get response similar to {"TEST_SECRET":"SECRET_VAL"}
### this can be used in your code
# Telecommunications and internet provider system
Eimantas Markevičius  
Artūras Petruškevičius  
Tadas Vainutis  
Valdas Karčauskas  
Vytautas Ruzgus

# Requirements
PHP 7.1.3 or higher  
composer

# Technology used  
Symfony 4.1.4  
PHP 7.2 
composer

# Basic set up
Clone this repository  
Run composer install  
Run php -S 127.0.0.1:8000 -t public  
Now your project should be accessible by going to http://127.0.0.1:8000

# Asset management
Install yarn https://yarnpkg.com/lang/en/docs/install/  
Install latest stable nodejs  
In project root directory run yarn add @symfony/webpack-encore --dev and yarn install  
Run yarn run encore production to compile all assets

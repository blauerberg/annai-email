## About The Email Application

The Email Application is built based on the Uber Code Challenge available at https://github.com/uber/coding-challenge-tools. It has been built on top of Laravel, Guzzle and PHP libraries provided by SendGrid and SparkPost for the backend and Bulma as a CSS framework for the frontend.

It provides both internal routing as well as an external facing API service for interacting with SendGrid and SparkPost. The idea behind this is that it will provide scalability if the application sits under a load balancer as well as providing external access if the application is to use decoupled architecture.

## Installation
The Email Application requires PHP 7 for Laravel support. To provide convenience for reviewing this application it comes with node packages required for the Bulma CSS Framework in the repository, however npm/yarn can be used to update packages. These packages sit in '/resources/assets/'. No MySQL database is required for this application.

## Build
To build the application, simply pull down the Master branch of this repository then:

* Copy and rename .env.example to .env
* Using terminal/shell, from the docroot execute 'php artisan key:generate' to set a app key for the .env file
* Add SENDGRID_API_KEY and SPARKPOST_API_KEY keys to the .env file. The API keys can be applied for from both SendGrid and SparkPost.

## Testing
The Email Application comes with tests to check that the SendGrid and SparkPost API endpoints are functioning correctly. From the docroot, run 'phpunit' and the tests will execute.

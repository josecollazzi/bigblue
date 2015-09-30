### Status
[![Build Status](https://travis-ci.org/lordkote/bigblue.png)](https://travis-ci.org/lordkote/bigblue)

# What is Big Blue

Big Blue provide Authentication and Authorization using Oaut2.

This app is part of the system Whales Watchers. A system that allow users to share information about Whales.

The Whales Watchers system is the combination of these modules:

* bigblue: oauth2 authenticated system rest api, -this project- (php)
* whitewhale: back-end api (php)
* rightwhale: website (html, css, javascript)
* mikewhale: proxy to solve cross-domain problems in the website (nodejs)
* finwhale:  mobile app (android)

Installation in your local machine (for unix):

### Using Vagrant and Ansible:

you should first install Vagrant and Ansible

From the root of the project execute this commands

```terminal
vagrant up
```

### end points

Create a client
POST http://192.168.33.106/app/client

Register a new user
POST http://192.168.33.106/app/user

Fetch a user:
GET http://192.168.33.106/app/user/{id_of_the_user}

User login:
GET http://192.168.33.106/app/login

Fetch a new refresh token
POST http://192.168.33.106/oauth/v2/auth

Fetch a new access token
POST http://192.168.33.106/oauth/v2/token


### Run test

First connect with the box

```terminal
vagrant ssh
```

then run the test from inside the box

```terminal
cd /opt/bigblue
./bin/phpspec run
./bin/phpunit -c app/
```

vagrant ssh ,allow you to connect with your vagrant box

./bin/phpspec run, run the unitest written in phpspec
./bin/phpunit, run the functional test written in phpunit

you can close the box´s connexion:

```terminal
exit
```

### deployment

#### The deployment using Heroku

command to deploy in Heroku

The heroku "instance" should provide these variables

SYMFONY__DATABASE__USER
SYMFONY__DATABASE__PASSWORD
SYMFONY__DATABASE__NAME
SYMFONY__DATABASE__HOST
SYMFONY__DATABASE__DRIVER
SYMFONY_ENV=prod

We can configure this variables by adding:

```terminal
....
```


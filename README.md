Symfony Demo Application
========================

## Install

### Requirements

In order to run this project, you need to install several tools to reproduce the same environment easily:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/overview/)

### Installation

```bash
$ git clone https://github.com/thinkfab/symfony_demo_3.4.git
$ cd symfony_demo/
$ make install

# Take a cup of coffee... ;)
```

This command will just clone the project repository, setup a whole dev environment through docker machines (one by entry in the `docker-compose.yml` file) and setup database structure with migrations.

You'll certainly be prompted for some consumer key / secret from bitbucket during composer install. Just generate and tape it, it'll not ask again in the future.

## Development

### Starting Project

A single command allows you to run the project:

```sh
make start
```

App instance runs on 8100 port, you can access it on `http://localhost:8110`.

### Stopping Project

If you need to stop all project containers, just use:

```sh
make stop
```

### Logs

You can access logs from php container with `make logs`. It's just a shortcut to the docker-compose log command.

If you need more logs on other container, you can use either docker-compose or docker command like:

`docker-compose logs -f php`

Or

`docker logs <full name or id of your container>` (obtained with `docker ps`)

Sometimes, logs are not enought you'll investiguate from into the containers. To do that, just tape `make connect` and you'll be connected into the php container.

### Database access

All databases ports from this project are incrementally mapped to local ports on your machine which allows to access them from a database explorer software (like Dbeaver...).

- 3346 => sf_test

You can import sql scripts the same way as you makes usually. For exemple:

```
mysql --host=127.0.0.1 --port=3346 --user=root --password=p@ssword sf_test < myscript.sql
```

# pieewiee/PHP-QR-Code-API:latest

- [Introduction](#introduction)
- [Getting started](#getting-started)
  - [Installation](#installation)
  - [Quickstart](#quickstart)

# Introduction

`Dockerfile` to create a [Docker](https://www.docker.com/) container image for [phpqrcode](http://phpqrcode.sourceforge.net/) 




# Getting started

## Installation

Automated builds of the image are available on [Dockerhub](https://hub.docker.com/r/pieewiee/PHP-QR-Code-API) and is the recommended method of installation.


```bash
docker pull pieewiee/PHP-QR-Code-API:latest
```

Alternatively you can build the image yourself.

```bash
docker build -t github.com/pieewiee/PHP-QR-Code-API
```

## Quickstart

Start PHP-QR-Code-API Server using:

```bash
docker run --name license -d --restart=always \
  --publish 80:80/tcp \
  pieewiee/PHP-QR-Code-API:latest
```

*Alternatively, you can use the sample [docker-compose.yml](docker-compose.yml) file to start the container using [Docker Compose](https://docs.docker.com/compose/)*

When the container is started the [phpqrcode](http://phpqrcode.sourceforge.net/) service is also started and is accessible from the web browser at https://localhost:80. 



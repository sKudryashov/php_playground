#!/bin/bash
workdir=`pwd`
http_port=80
debug_port=9001
rabbitmq_port=5672
rabbitmq_host=127.0.0.1
mysql_host=127.0.0.1
mysql_port=3302
docker_image_name=

sudo /usr/local/bin/boot2docker up


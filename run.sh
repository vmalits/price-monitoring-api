#!/bin/bash
# Script runs containers

cd laradock
docker-compose up -d nginx postgres workspace mailhog

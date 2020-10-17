#!/bin/bash
# Script runs containers

cd laradock-pm
docker-compose up -d nginx postgres workspace mailhog

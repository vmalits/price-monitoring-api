#!/bin/bash
# Script checks the code style (PSR 1 PSR 2)

./vendor/bin/phpcs --standard=PSR2 app/

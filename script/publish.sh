#!/bin/sh

CURRENT_DIR=`dirname "${0}"`
LARAVEL_ROOT_DIR=$CURRENT_DIR"/../../../../"


cd $LARAVEL_ROOT_DIR

php artisan vendor:publish --force --provider='Tsuzukit\NaiveBayse\NaiveBayseServiceProvider'

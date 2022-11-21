#!/usr/bin/env bash

symfony console doctrine:database:drop --force
symfony console doctrine:database:create
symfony console doctrine:schema:create
symfony console doctrine:fixtures:load -n

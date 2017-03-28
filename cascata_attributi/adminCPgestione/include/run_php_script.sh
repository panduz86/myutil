#!/bin/bash

ORA="$(date)"

echo "$ORA - START CRON SCRIPT"

echo "$ORA - START CRON SCRIPT" >> ${0##*/}.log

PHP="$(which php)"

PATH_FILE_PHP="/var/www/vhosts/webscrivania.it/adminCPgestione/cron.php"

$PHP $PATH_FILE_PHP >> ${0##*/}.log

ORA="$(date)"

echo "$ORA - END CRON SCRIPT"

echo "$ORA - END CRON SCRIPT" >> ${0##*/}.log



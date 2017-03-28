#!/bin/bash

 
MyUSER="userwebDB"        # USERNAME
MyPASS="ROOT#hLweb#w5" # PASSWORD
MyHOST="localhost"       # Hostname
MyDB="webscribazDB"    # Database

# Linux bin paths, change this if it can not be autodetected via which command
MYSQL="$(which mysql)"
MYSQLDUMP="$(which mysqldump)"
CHOWN="$(which chown)"
CHMOD="$(which chmod)"
GZIP="$(which gzip)"
PHP="$(which php)"
NOW="$(date +"%Y-%m-%d")"
NOME_FILE="$(date +"%Y-%m-%d_%H%M%S")"

 
# Backup Dest directory, change this if you have someother location
DEST="/var/www/vhosts/webscrivania.it/adminCPgestione"
 
# Main directory where backup will be stored
MBD="$DEST/bk_db"
 
# Get hostname
HOST="$(hostname)"

 
# File to store current backup file
FILE=""
# Store list of databases
DBS=""
 
# DO NOT BACKUP these databases
IGGY="test"
 
# [ ! -d $MBD ] && mkdir -p $MBD || :

FILE="$MBD/copia_db_del$NOME_FILE.sql"

# Delete previous dump
if [ -c $FILE ]
then
  rm $FILE
fi


$MYSQLDUMP -u $MyUSER -h $MyHOST -p$MyPASS $MyDB > $FILE

$MYSQL -u $MyUSER -p$MyPASS $MyDB -e "INSERT INTO bazar_backup (stato,data_creazione,nome_file) VALUES (1,'$NOW','copia_db_del$NOME_FILE.sql')"

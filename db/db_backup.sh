#!/usr/bin/env bash

# скрипт для бэкапа актуальной версии БД

source db.conf
MYSQLDUMPBIN="$(which mysqldump)"
NOW=$(date +"%y%m%d%H%M")
$MYSQLDUMPBIN --add-drop-table --allow-keywords --create-options --skip-comments -e -q -c -u $DBUSER -p$DBUSERPASSWORD $DBNAME > "$PATHTOSAVEDB"actual_db_$NOW.sql
cp "$PATHTOSAVEDB"actual_db_$NOW.sql "$PATHTOSAVEDB"current_db.sql
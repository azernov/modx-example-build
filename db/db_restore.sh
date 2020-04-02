#!/usr/bin/env bash

# восстановление БД из последнего бэкапа

source db.conf
mysql -u $DBUSER -p$DBUSERPASSWORD $DBNAME < "$PATHTOSAVEDB"current_db.sql

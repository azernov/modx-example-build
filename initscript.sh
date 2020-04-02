#!/usr/bin/env bash

ANSWER=''
while [[ ! $ANSWER =~ ^[YyNn] ]]; do
    echo -n "Please check you have current_db.sql in db/localdb. [Y/n]: "
    read ANSWER
done

if [[ $ANSWER =~ ^[Nn] ]]; then
    echo "Please create db/localdb/current_db.sql"
    exit 1
fi

# Запросить ввод имени БД
DBNAME=''
while [ "$DBNAME" = "" ]; do
    echo -n "Enter data base name: "
    read DBNAME
done

# Запросить ввод имени пользователя БД
DBUSER=''
while [ "$DBUSER" = "" ]; do
    echo -n "Enter data base user: "
    read DBUSER
done

# Запросить ввод пароля БД
DBUSERPASSWORD=''
while [ "$DBUSERPASSWORD" = "" ]; do
    echo -n "Enter data base user password: "
    read -s DBUSERPASSWORD
done

# Сделать копию db/db.sample.conf -> db/db.conf и вставить туда реквизиты
cp db/db.sample.conf db/db.conf

sed -E "s/(DBNAME=\")[^\"]*(\")/\1$DBNAME\2/
s/(DBUSER=\")[^\"]*(\")/\1$DBUSER\2/
s/(DBUSERPASSWORD=\")[^\"]*(\")/\1$DBUSERPASSWORD\2/" db/db.conf > db/db.conf.tmp

rm db/db.conf
mv db/db.conf.tmp db/db.conf

# Сделать копию www/core/config/config.inc.sample.php -> www/core/config/config.inc.php
cp www/core/config/config.inc.sample.php www/core/config/config.inc.php

sed -E "s/(\\\$database_user = ')[^']*(')/\1$DBUSER\2/
s/(\\\$database_password = ')[^']*(')/\1$DBUSERPASSWORD\2/
s/(\\\$dbase = ')[^']*(')/\1$DBNAME\2/
s/(\\\$database_dsn = 'mysql:host=)([^;]+);dbname=[^;]*(;charset=)([^']+)';/\1\2;dbname=$DBNAME\3\4';/" www/core/config/config.inc.php > www/core/config/config.inc.tmp.php

rm www/core/config/config.inc.php
mv www/core/config/config.inc.tmp.php www/core/config/config.inc.php

# Сделать копию www/core/components/gitmodx/config.sample -> www/core/components/gitmodx/config
cp -r www/core/components/gitmodx/config.sample www/core/components/gitmodx/config


# Переходим в рабочий каталог
cd db

# Запускаем генерацию БД
./create_db_and_user.sh

# Заливаем БД
./db_restore.sh
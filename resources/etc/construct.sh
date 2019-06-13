#!/bin/bash

key=$1

chmod 777 ~/src/${key}_movie/storage/*
chmod 777 ~/src/${key}_movie/storage/framework/*
ln -nfs ~/src/${key}_movie/resources/etc/production/httpd.conf ~/conf/${key}_movie.conf
ln -nfs ~/src/${key}_movie/public ~/www/htdocs_${key}_movie
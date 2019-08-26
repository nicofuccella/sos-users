#!/usr/bin/env bash

mkdir -p cert;
cd cert;
openssl req -newkey rsa:3072 -new -x509 -days 3652 -nodes -out googleappsidp.crt -keyout googleappsidp.pem

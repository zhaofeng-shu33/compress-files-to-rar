#!/bin/bash
export LOCALRAR=1
cp /usr/local/bin/rar ./
php test.php
./integration_test.sh
rm rar
unset LOCALRAR

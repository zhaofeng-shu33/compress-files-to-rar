#!/bin/bash
export LOCALRAR=1
cp /usr/local/bin/rar ./
php test.php
./integration_test.sh
# do not remove the rar on travis ci
if [[ ! -v $TRAVIS ]]; then
  rm rar
fi
unset LOCALRAR

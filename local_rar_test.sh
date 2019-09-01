#!/bin/bash
export LOCALRAR=1
if [[ -z "$TRAVIS" ]]; then
  rm -r rar
fi
cp /usr/local/bin/rar ./
php test.php
./integration_test.sh
# do not remove the rar on travis ci
if [[ ! -z "$TRAVIS" ]]; then
  rm rar
fi
unset LOCALRAR

#!/bin/bash
php -S localhost:8231 &
echo $! > php_local_server.pid
sleep 1
curl -i -F "filename=a.rar" -F "userfile[]=@index.php" -F "userfile[]=@test.php" http://localhost:8231 -o a.rar
kill $(cat php_local_server.pid)
php check_integration.php

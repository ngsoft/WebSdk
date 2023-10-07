@echo off
echo Stopping MariaDB...
pushd "%~dp0..\..\mariadb"
    bin\mariadb-admin.exe shutdown -uroot -ptoor > NUL 2>&1
popd

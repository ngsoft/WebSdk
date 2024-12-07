@echo off
echo Stopping MariaDB...
pushd "%~dp0..\..\mariadb"
    bin\mariadb-admin.exe shutdown -uroot -ptoor > NUL 2>&1
    if ERRORLEVEL 0 (
        if "%starting%" == "true" (
            %WINDIR%\System32\timeout.exe /T 5 /NOBREAK  > NUL 2>&1
        )
    )
popd

@echo off
if not exist "%~dp0databases\mysql" (
    echo Installing databases...
    pushd %~dp0
        bin\mariadb-install-db.exe -R -D -p toor -c .\my-default.ini
    popd
    %WINDIR%\System32\timeout.exe /t 5 /NOBREAK
    exit /b
)


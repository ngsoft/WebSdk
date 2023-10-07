@echo off
setlocal
call "%~dp0..\loadenv.bat"
pushd "%mariadb%"
    if not exist "databases\mysql" (
        echo.
        echo Setup for mariadb is not done
        echo To run %WEB_SDK%setup.bat
        echo.
        pause
        call %WEB_SDK%setup.bat
    ) else (
        set starting=true
        call "%sdk%scripts\stop-mariadb.bat" > NUL
    )
    echo Starting MariaDB on port 3306...
    "%sdk%daemonize.exe" bin\mariadbd.exe --defaults-file=databases\my.ini --console
popd

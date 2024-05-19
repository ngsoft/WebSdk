@echo off
setlocal
call "%~dp0..\loadenv.bat"
pushd "%mariadb%"
    if not exist "databases\mysql" (
        echo.
        echo Setup for mariadb is not done
        echo running %mariadb%setup.bat
        echo.
        call %mariadb%setup.bat
    ) else (
        set starting=true
        call "%sdk%scripts\stop-mariadb.bat" > NUL
    )
    echo Starting MariaDB on port 3306...
    "%sdk%daemonize.exe" bin\mariadbd.exe --defaults-file=databases\my.ini --console
popd

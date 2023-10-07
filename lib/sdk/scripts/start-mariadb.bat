@echo off
setlocal
call %~dp0stop-mariadb.bat > NUL
call "%~dp0..\loadenv.bat"

pushd "%mariadb%"
    if not exist "databases\mysql" (
        echo Setup for mariadb is not done
        echo To run %mariadb%setup.bat
        pause
        call .\setup.bat
    )

    echo Starting MariaDB on port 3306...
    "%sdk%daemonize.exe" bin\mariadbd.exe --defaults-file=databases\my.ini --console
popd

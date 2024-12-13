@echo off
setlocal
@REM Loads Environment
call "%~dp0..\loadenv.bat"

@REM Checks UAC
NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
@REM Run elevated
"%elevate%" "%sdk%daemonize.exe" cmd.exe /C "%~fx0"
goto :eof
:script
@REM Run Script Elevated
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

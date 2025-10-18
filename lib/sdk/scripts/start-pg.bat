@echo off
setlocal

echo Starting PostgreSQL on port 5432...

@REM Loads Environment
call "%~dp0..\loadenv.bat"

@REM Checks UAC
NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
@REM Run elevated
"%elevate%" "%daemonize%" cmd.exe /C "%~fx0"
goto :eof

:script
@REM Run Script Elevated
pushd "%pgdb%"
    if not exist "%pgversion%\databases\postgresql.conf" (
        echo.
        echo Setup for PostgreSQL is not done
        echo running %pgdb%setup.bat
        echo.
        call %pgdb%setup.bat
    ) else (
        set starting=true
        call "%~dp0\stop-pg.bat"
    )
    call .\env.bat
    "%daemonize%" "%pgversion%\bin\pg_ctl.exe" -D "%PGDATA%" -l "%pgdb%\%pgversion%\logs\pgsql.log" start
popd

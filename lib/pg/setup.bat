@echo off

call "%~dp0env.bat"

if not exist "%PGDATA%" (
    %PG_ROOT%bin\initdb.exe -U %PGUSER% -A trust --locale en_US.UTF-8
)

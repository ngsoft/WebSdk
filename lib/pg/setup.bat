@echo off

call "%~dp0env.bat"

if not exist "%PGDATA%" (
    %~dp0bin\initdb.exe -U %PGUSER% -A trust --locale en_US.UTF-8
)
@echo off
echo Starting Nginx on port 80...

setlocal
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
call "%~dp0stop-nginx.bat" > NUL 2>&1
taskkill /F /IM httpd.exe > NUL 2>&1
set "config_file=conf\nginx.conf"
if exist "%ca%localhost\cert.pem" (
    set "config_file=conf\nginx-ssl.conf"
)
pushd "%nginx%"
    "%daemonize%" .\nginx.exe -c %config_file%
popd





@echo off
setlocal

echo Stopping Apache...

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
pushd "%httpd%"
    httpd.exe -k stop -n httpd
    httpd.exe -k uninstall -n httpd
popd
taskkill /f /IM httpd.exe > NUL 2>&1

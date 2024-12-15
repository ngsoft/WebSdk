@echo off
setlocal

echo Starting Apache on port 80...

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
call "%~dp0stop-httpd.bat"
call "%~dp0stop-cgi.bat"
taskkill /f /IM nginx.exe > NUL 2>&1
pushd "%httpd%"
    "%daemonize%" httpd.exe
popd


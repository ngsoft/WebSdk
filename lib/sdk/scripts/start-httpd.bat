@echo off
setlocal

echo Starting Apache on port 80...

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
call "%~dp0stop-httpd.bat"
taskkill /f /IM nginx.exe > NUL 2>&1
pushd "%httpd%"
    "%sdk%daemonize.exe" httpd.exe
popd


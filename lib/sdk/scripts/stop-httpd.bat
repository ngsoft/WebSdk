@echo off
setlocal

echo Stopping Apache...

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
taskkill /f /IM httpd.exe > NUL 2>&1

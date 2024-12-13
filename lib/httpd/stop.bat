@echo off
setlocal
@REM Loads Environment
call "%~dp0..\sdk\loadenv.bat"

@REM Checks UAC
NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
@REM Run elevated
"%elevate%" "%sdk%daemonize.exe" cmd.exe /C "%~fx0"
goto :eof
:script
@REM Run Script Elevated
taskkill /f /IM httpd.exe > NUL 2>&1
taskkill /f /IM nginx.exe > NUL 2>&1
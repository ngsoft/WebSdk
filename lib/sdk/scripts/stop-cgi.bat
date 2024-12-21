@echo off
setlocal

echo Stopping PHP FastCGI...

@REM Loads Environment
call "%~dp0..\loadenv.bat"

@REM Create PHP OPCache storage
md "%WEB_SDK%tmp\opcache" > NUL 2>&1
md "%WEB_SDK%tmp\opcache\8.2" > NUL 2>&1
md "%WEB_SDK%tmp\opcache\8.3" > NUL 2>&1
md "%WEB_SDK%tmp\opcache\8.4" > NUL 2>&1


@REM Checks UAC
NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
@REM Run elevated
"%elevate%" "%daemonize%" cmd.exe /C "%~fx0"
goto :eof
:script
@REM Run Script Elevated
taskkill /F /IM php-cgi-spawner.exe  > NUL 2>&1
taskkill /F /IM php-cgi.exe  > NUL 2>&1
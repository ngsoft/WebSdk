@echo off
setlocal
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
call "%~dp0stop-nginx.bat" > NUL 2>&1
call "%~dp0..\loadenv.bat"
taskkill /F /IM httpd.exe > NUL 2>&1
pushd "%nginx%"
    echo Starting Nginx on port 80...
    "%sdk%daemonize.exe" .\nginx.exe
popd





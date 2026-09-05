@echo off
setlocal

echo Stopping Redis...

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
pushd "%redis%"
    RedisService.exe uninstall
popd
taskkill /f /IM redis-server.exe > NUL 2>&1

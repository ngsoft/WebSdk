@echo off
setlocal

echo Starting Redis on port 6379...

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
    mkdir "%redis%data" > NUL 2>&1
    RedisService.exe install -c "%redis%redis.conf" --dir "%redis%data" --port 6379
    "%WINDIR%\System32\sc.exe" config Redis start=demand
    net start Redis
popd


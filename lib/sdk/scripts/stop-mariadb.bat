@echo off
setlocal

echo Stopping MariaDB...

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
pushd "%mariadb%"
    bin\mariadb-admin.exe shutdown -uroot -ptoor > NUL 2>&1
    if "%starting%" == "true" (
        %WINDIR%\System32\timeout.exe /T 5 /NOBREAK  > NUL 2>&1
    )
popd

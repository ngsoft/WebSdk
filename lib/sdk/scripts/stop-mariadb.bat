@echo off
setlocal

echo Stopping MariaDB...

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
pushd "%~dp0..\..\mariadb"
    bin\mariadb-admin.exe shutdown -uroot -ptoor > NUL 2>&1
    if ERRORLEVEL 0 (
        if "%starting%" == "true" (
            %WINDIR%\System32\timeout.exe /T 5 /NOBREAK  > NUL 2>&1
        )
    )
popd

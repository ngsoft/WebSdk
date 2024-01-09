@echo off

@REM Prevent composer self update
echo "%*" | findstr /C:"selfupdate" > NUL 2>&1
if not ERRORLEVEL 1 goto cannot_self_update
echo "%*" | findstr /C:"self-update" > NUL 2>&1
if not ERRORLEVEL 1 goto cannot_self_update
goto main

:cannot_self_update
echo.
echo   Composer LTS 2.2 is configured to work with PHP 5.5
echo   So you cannot update it to a newer version
echo.
goto :eof


:main
setlocal enabledelayedexpansion
call "%~dp0..\lib\sdk\loadenv.bat"
if "%COMPOSER_LTS_HOME%" == "" (
    set "COMPOSER_LTS_HOME=%etc%composer-lts"
)
set "COMPOSER_HOME=%COMPOSER_LTS_HOME%"
"%php55%php.exe" "%sdk%composer-lts.phar" %*

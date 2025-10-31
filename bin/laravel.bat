@echo off

setlocal
set "script_root=%~dp0..\lib\laravel"
set "runtime=%script_root%\vendor\bin\laravel.bat"
goto main

:update
if not exist "%runtime%" goto install
pushd "%script_root%"
call "%~dp0composer.bat" update
popd
goto :eof


:install
md "%script_root%"
pushd "%script_root%"
call "%~dp0composer.bat" --dev require laravel/installer
popd
@REM Prevent infinite loops
if not exist "%runtime%" goto :eof


:main
if not exist "%runtime%" goto install
if [%~1] == [update] goto update
if exist artisan (
    php artisan %*
    exit /b %ERRORLEVEL%
)
call "%runtime%" %*




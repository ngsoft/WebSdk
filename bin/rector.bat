@echo off

setlocal
call "%~dp0../lib/sdk/loadenv.bat"
set "php=%php82%"
set "script_root=%lib%rector"
set "runtime_detect_dir=vendor\bin"
set "runtime_detect=%runtime_detect_dir%\rector"
set "runtime_root=%script_root%\%runtime_detect_dir%"
set "runtime=%script_root%\%runtime_detect%"
set "config_file=rector.php"
set "template_file=%etc%rector.dist.php"
goto main

:update
if not exist "%runtime%" goto install
pushd "%script_root%"
call "%~dp0composer.bat" update
popd
exit /b

:install
md "%script_root%"
pushd "%script_root%"
"%php%php.exe" "%~dp0composer.phar" require "rector/rector:^2.0" --dev
@REM call "%~dp0composer.bat" require "rector/rector:^2.0" --dev
popd
@REM Prevent infinite loops
if not exist "%runtime%" exit /b 1


:main
if not exist "%runtime%" call :install
if [%~1] == [update] goto update


if [setup] == [%~1] (
    if exist composer.json if not exist "%config_file%" (
        copy "%template_file%" "%config_file%" > NUL
        echo %config_file% has been generated from template, please review it.
        @REM if not exist "%runtime_detect%" call "%~dp0composer.bat" require "rector/rector:^2.0" --dev
        if not exist "%runtime_detect%" "%php%php.exe" "%~dp0composer.phar" require "rector/rector:^2.0" --dev
        exit /b
    )
    echo cannot setup rector, composer.json not present or %config_file% exists.
    exit /b 1
)



setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%runtime%
SET "COMPOSER_RUNTIME_BIN_DIR=%runtime_root%"
"%php%php.exe" "%BIN_TARGET%" %*

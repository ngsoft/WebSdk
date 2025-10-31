@echo off

setlocal
call "%~dp0../lib/sdk/loadenv.bat"
set "script_root=%lib%php-cs-fixer"
set "runtime=%script_root%\vendor\bin\php-cs-fixer.bat"
set "config_file=.php-cs-fixer.dist.php"
set "template_file=%etc%.php-cs-fixer.dist"
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
call "%~dp0composer.bat" --dev require friendsofphp/php-cs-fixer
popd
@REM Prevent infinite loops
if not exist "%runtime%" exit /b 1


:main
if not exist "%runtime%" call :install
if [%~1] == [update] goto update
if [fix] == [%~1] if exist composer.json if not exist "%config_file%" (
    copy "%template_file%" "%config_file%" > NUL
    echo %config_file% has been generated from template, please review it.
)

call "%runtime%" %*


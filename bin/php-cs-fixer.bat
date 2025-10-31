@echo off

setlocal
call "%~dp0../lib/sdk/loadenv.bat"
set "script_root=%lib%php-cs-fixer"
set "runtime=%script_root%\vendor\bin\php-cs-fixer.bat"
set "config_file=%etc%.php-cs-fixer.dist"
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
if [%~1] == [update] call :update

if [%~1] == [autofix] (
    call "%runtime%" fix %2 --config=%config_file%
    exit /b %ERRORLEVEL%
)

call "%runtime%" %*


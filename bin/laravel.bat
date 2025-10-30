@echo off

setlocal
set "script_root=%~dp0..\lib\laravel"
set "runtime=%script_root%\vendor\bin\laravel.bat"
goto main

:update
if not exist "%runtime%" goto install
pushd "%script_root%"
call "%~dp0composer8.4.bat" update
popd
goto :eof


:install
md "%script_root%"
pushd "%script_root%"
call "%~dp0composer8.4.bat" --dev require laravel/installer
popd
@REM Prevent infinite loops
if not exist "%runtime%" goto :eof


:main
if not exist "%runtime%" goto install
if [%~1] == [update] goto update
if not defined php (
    call "%~dp0..\lib\sdk\loadenv.bat"
)
@REM Use PHP 8.4 Runtime
set "PATH=%php84%;%PATH%"
call "%runtime%" %*




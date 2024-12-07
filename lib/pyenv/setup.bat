@echo off
goto main

:add_env [%1 - Name, %2 - Value] (
    if "%~1" == "" exit /b 1
    if "%~2" == "" exit /b 1

    echo Adding %~1 to environement
    @REM Register to User
    %sdk%regenv.exe set -nU -x "%~1" "%~2\"
    @REM Set Current Environment
    set "%~1=%~2"
    exit /b
)

:prepend_global_path [%1 - path, %2 - check] (
    if "%~1" == "" exit /b 1
    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b 1
        )
    )
    @REM Prepend to system path as microsoft store has a python executable 
    @REM that launch the store
    reg query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        %sdk%regenv.exe set -nS -sp -x PATH "%~1" 2> NUL
    )
    exit /b %ERRORLEVEL%
)

:add_path [%1 - path, %2 - check] (
    if "%~1" == "" exit /b 1
    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b 1
        )
    )
  
    reg query HKCU\Environment /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        %sdk%regenv.exe set -nU -sa -x PATH "%~1"
    )
    exit /b
)


:install_python [%1 - version] (
    @REM pyenv is just a tool to install customized python version
    @REM the shim can prevent pip or installed scripts form working properly
    @REM so we install python and symlink into previous location
    set "PYENV=%~dp0"
    set "PYENV_ROOT=%~dp0"
    set "PYENV_HOME=%~dp0"

    if not exist "%~dp0.versions_cache.xml" (
        call "%~dp0bin\pyenv.bat" update
    )
    if not exist "%~dp0versions\%~1\python.exe" (
        call "%~dp0bin\pyenv.bat" install "%~1" --dev
    )
    exit /b
)

:main
setlocal enabledelayedexpansion

call "%~dp0..\sdk\loadenv.bat"
@REM Install Python Environment
echo Setting up python %pyversion% ...

@REM checking env (we need elevation for system %PATH%)
call :prepend_global_path "%~dp0versions\%pyversion%" false
if ERRORLEVEL 1 (
    echo You must run this script as an administrator for it to work
    exit /b 1
)
call :prepend_global_path "%~dp0versions\%pyversion%\Scripts" false
call :install_python "%pyversion%"

if not exist "%py3%" (
    echo Python %pyversion% was not installed, please run setup again.
    exit /b 1
)

echo Installing/Updating essential modules ...
"%py3%python.exe" -m pip install --upgrade pip virtualenv pyinstaller pipupgrade --no-warn-script-location

@REM pipupgrade --verbose --latest --yes
@REM Its done!
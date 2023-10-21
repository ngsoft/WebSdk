@echo off
goto main


:addpath_sdk [%1 - path, %2 - check] (
    call :add_path "%WEB_SDK%%~1" "%~2"
    exit /b
)

:add_path [%1 - path, %2 - check] (
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
        %sdk%regenv.exe set -nS -sp -x PATH "%~1"
    )
    exit /b
)

:main
setlocal enabledelayedexpansion
call "%~dp0/loadenv.bat"

@REM Install Python Environment
echo Setting up python ...

for %%f in (lib\python\venv\Scripts) do (
    call :addpath_sdk "%%f" false
)


if not exist "%py3%python.exe" (
    pushd "%WEB_SDK%tmp"
        if not exist py.zip (
            echo Download Python 3.12 ...
            %WEB_SDK%bin/wget.exe "https://www.python.org/ftp/python/3.12.0/python-3.12.0-embed-amd64.zip" -O py.zip
        )
        echo Extract Python binaries
        md "%py3%" > NUL 2>&1
        powershell.exe -Command "Expand-Archive -Force -Path .\py.zip -DestinationPath %lib%python"
    popd
)

pushd "%py3%"
    @REM Install PIP
    if not exist get-pip.py (
        %WEB_SDK%bin\wget.exe https://bootstrap.pypa.io/get-pip.py -O get-pip.py
    )
    if not exist venv\Scripts\python.exe (
        .\python.exe get-pip.py --no-warn-script-location
        @REM Install VirtualEnv
        .\python.exe -m pip install virtualenv --no-warn-script-location
        @REM Activate venv
        .\python.exe -m virtualenv venv
        del /Q /F .\venv\Scripts\activate.*
        del /Q /F .\venv\Scripts\deactivate.*
    )
    @rem Install PIP + PyInstaller + Setup env
    pushd venv\Scripts
        .\python.exe -m pip install --upgrade pip
        .\python.exe -m pip install --upgrade pyinstaller --no-warn-script-location
    popd

popd




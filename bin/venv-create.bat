@echo off
setlocal
if NOT [%~1] == [] goto main

:usage
echo venv-create [name] >& 2
exit /b 1

:addpath [%1 - path, %2 - check] (

    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b
        )
    )
    reg query HKCU\Environment /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        "%sdk%regenv.exe" set -nU -sa -x PATH "%~1"
    )
    exit /b
)


:main
call "%~dp0..\lib\sdk\loadenv.bat"
set "project=%~1"
set "project_root=%lib%pyenv\venv\%project%"

if exist "%project_root%" (
    code "%project_root%"
    exit /b 0
)

echo create %project_root%
mkdir "%project_root%\bin"
call :addpath "%project_root%\bin"
pushd "%project_root%"
    echo Updating pip
    call py.bat -m pip install --upgrade pip
    echo create %project_root%\.venv
    call py.bat -m venv .venv
    call .venv\Scripts\activate.bat
    pushd bin
        echo create %project_root%\bin\%project%.bat
        echo @echo off > "%project%.bat"
        echo call %~dp0.venv\Scripts\activate.bat >> "%project%.bat"
    popd
    echo open code editor in %project_root%
    code .
popd
exit /b 0
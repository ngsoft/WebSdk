@echo off
setlocal enabledelayedexpansion
set add_to_path=false
set add_scripts_to_path=false
set help=false
set "project="

echo "%*" | findstr /C:"/?" > NUL 2>&1
if not ERRORLEVEL 1 set help=true

@REM set argCount=0
for %%x in (%*) do (
    @REM set /A argCount+=1
    if [-p] == [%%~x] (
        set add_to_path=true
    ) else if [/p] == [%%~x] (
        set add_to_path=true
    ) else if [-s] == [%%~x] (
        set add_scripts_to_path=true
    ) else if [/s] == [%%~x] (
    set add_scripts_to_path=true
    ) else if [--help] == [%%~x] (
        set help=true
    ) else if "[!project!]" == "[]" (
        set "project=%%~x"
    )
)

if [true] == [%help%] goto usage
if NOT "[%project%]" == "[]" goto main

:usage
echo Create a python virtual environment project
echo     venv-create [project_name] [options] >&2
echo.
echo Options: >&2
echo     --help,/? this help >&2
echo     -s,/s     add python scripts from project venv to path >&2
echo     -p,/p     add scripts from project bin to path >&2
echo.
exit /b 1

:addpath [%1 - path, %2 - check] (
    if [%add_to_path%] == [false] exit /b
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
if [%add_to_path%] == [true] call :addpath "%project_root%\bin"
if [%add_scripts_to_path%] == [true] call :addpath "%project_root%\.venv\Scripts"
pushd "%project_root%"
    echo Updating pip
    call py.bat -m pip install --upgrade pip
    echo create %project_root%\.venv
    call py.bat -m venv .venv
    call .venv\Scripts\activate.bat
    pushd bin
        echo create %project_root%\bin\%project%.bat
        echo @echo off > "%project%.bat"
        echo pushd "%project_root%" >> "%project%.bat"
        echo call .venv\Scripts\activate.bat >> "%project%.bat"
        echo popd >> "%project%.bat"
        echo @REM put your code there >> "%project%.bat"
    popd
    echo open code editor in %project_root%
    code .
popd
exit /b 0
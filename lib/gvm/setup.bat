@echo off
goto main

:add_path [%1 - path, %2 - check] (
    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b
        )
    )
    reg query HKCU\Environment /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        %sdk%regenv.exe set -nU -sa -x PATH "%~1"
    )
    exit /b
)


:add_env [%1 - Name, %2 - Value] (
    if "%~1" == "" exit /b 1
    if "%~2" == "" exit /b 1
    echo Adding %~1 to environement
    @REM Register to User
    %sdk%regenv.exe set -nU -x "%~1" "%~2"
    @REM Set Current Environment
    set "%~1=%~2"
    exit /b
)

:main
setlocal enabledelayedexpansion
call "%~dp0../sdk/loadenv.bat"
@REM Go Path
echo Setting up go %goversion% ...
setx GOROOT "%lib%go" > NUL 2>&1
call :add_path "%%%%GOROOT%%%%\bin" false
call :add_path "%USERPROFILE%\go\bin" false

@REM Check if a link and removes it
dir "%~dp0.." | findstr SYMLINKD | findstr go > NUL 2>&1
if "%ERRORLEVEL%" == "0" (
    echo Removing go previous installed version
    rmdir "%go%"
)

@REM Check if no go (previous installer)
if exist "%go%" (
    echo Please remove %go% and run the setup again.
    exit /b 1
)

@REM installation
pushd "%~dp0"
    gvm.exe --home %gvm% %goversion% > NUL 2>&1
    if exist "%gvm%versions\go%goversion%.windows.amd64" (
        mklink /D "%lib%go" "gvm\versions\go%goversion%.windows.amd64"
        if ERRORLEVEL 1 (
            echo You must run this script as an administrator for it to work
            exit /b 1
        )
    )
popd

if not exist "%go%bin\go.exe" (
    echo Go cannot be installed, an error has occured
    exit /b 1
)

echo Setting up go %goversion% environement ...
"%go%bin\go.exe" env -w CGO_ENABLED=1
"%go%bin\go.exe" env -w GO111MODULE=on
@rem its done !
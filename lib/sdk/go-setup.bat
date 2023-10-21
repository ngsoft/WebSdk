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
call "%~dp0/loadenv.bat"

@REM Go Path
echo Setting up go ...
setx GOROOT "%lib%go" > NUL 2>&1
call :add_path "%%%%GOROOT%%%%\bin" false

if not exist "%go%bin\go.exe" (
    pushd "%WEB_SDK%tmp"
        if not exist go.zip (
            echo Downloading go 1.21.3
            %WEB_SDK%bin\wget.exe "https://go.dev/dl/go1.21.3.windows-amd64.zip" -O go.zip
        )
        echo Extracting Go binaries...
        powershell.exe -Command "Expand-Archive -Force -Path .\go.zip -DestinationPath %WEB_SDK%lib"
        if not ERRORLEVEL 1 (
            del /Q /F go.zip > NUL 2>&1
        )
    popd
)





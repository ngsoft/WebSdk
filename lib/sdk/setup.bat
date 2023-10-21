@echo off

goto main

:addpath_sdk [%1 - path] (
    call :addpath "%WEB_SDK%%~1"
    exit /b
)

:addpath [%1 - path, %2 - check] (

    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b
        )
    )
    reg query HKCU\Environment /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        regenv.exe set -nU -sa -x PATH "%~1"
    )
    exit /b
)

:install_nvm (
    set "NVM_HOME=%WEB_SDK%lib\nvm"
    set installed=false
    reg query HKCU\Environment /v NVM_HOME 2> NUL | findstr /C:"%NVM_HOME%" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Installing NVM...
        regenv.exe set -nU -x NVM_HOME "%NVM_HOME%"
        call :addpath "%NVM_HOME%"
        set installed=true
    )

    set "NVM_SYMLINK=%WEB_SDK%lib\nodejs"
    reg query HKCU\Environment /v NVM_SYMLINK 2>NUL | findstr /C:"%NVM_SYMLINK%" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Installing NVM Node Path...
        regenv.exe set -nU -x NVM_SYMLINK "%NVM_SYMLINK%"
        call :addpath "%NVM_SYMLINK%" false
        set installed=true
    )

    if "%installed%" == "true" (
        pushd "%nvm%"
            .\nvm.exe install latest
            .\nvm.exe use latest
        popd
    )
    exit /b
)


:main

setlocal enabledelayedexpansion
@REM Add Binaries to %PATH%
pushd "%~dp0"
    call loadenv.bat
    call :install_nvm
    for %%f in (bin lib\mariadb\bin lib\php\8.1 lib\php\7.4 lib\php\8.2 lib\php\5.6 lib\pear) do (
        call :addpath_sdk "%%f"
    )
popd
@REM Load Setup Scripts
pushd "%~dp0.."
    @REM Install Certs
    call certs\setup.bat
    @REM Setup Database
    call mariadb\setup.bat
popd
@REM Setup Composer
pushd "%~dp0"
    call composer-setup.bat
popd

@REM Setup Python
pushd "%~dp0"
    call python-setup.bat
popd

@REM Setup Go
pushd "%~dp0"
    call go-setup.bat
popd


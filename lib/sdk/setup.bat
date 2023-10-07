@echo off

goto main

:addpath [%1 - param] (

    echo $1 | findstr /c:":\" > NUL 2>&1
    if ERRORLEVEL 1 (
        set p="%~1"
    ) else (
        set p=%WEB_SDK%%~1
    )

    reg query HKCU\Environment /v PATH | findstr /C:"%p%" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %p% to PATH
        regenv.exe set -nU -sa -x PATH "%p%"
    )
    exit /b
)

:install_nvm (
    set p=%WEB_SDK%lib\nvm
    set installed=false
    reg query HKCU\Environment /v NVM_HOME 2> NUL | findstr /C:"%p%" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Installing NVM...
        regenv.exe set -nU -x NVM_HOME "%p%"
        set "NVM_HOME=%p%"
        call :addpath "%p%"
        set installed=true
    )

    set p=%WEB_SDK%lib\nodejs
    reg query HKCU\Environment /v NVM_SYMLINK 2>NUL | findstr /C:"%p%" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Installing NVM Node Path...
        regenv.exe set -nU -x NVM_SYMLINK "%p%"
        set "NVM_SYMLINK=%p%"
        call :addpath "lib\nodejs"
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
            call :addpath "%%f"
        )
    popd
    @REM Load Setup Scripts
    pushd "%~dp0.."
        @REM Install Certs
        call certs\setup.bat
        @REM Setup Database
        call mariadb\setup.bat
    popd






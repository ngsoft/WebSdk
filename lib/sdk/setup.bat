@echo off

goto main


:addpath [%1 - param] (
    set p=%WEB_SDK%%~1
    reg query HKCU\Environment /v PATH | findstr /C:"%p%" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %p% to PATH
        regenv.exe set -nU -sa -x PATH "%p%"
    )
    exit /b
)



:main

    setlocal enabledelayedexpansion
    @REM Add Binaries to %PATH%
    pushd "%~dp0"
        call loadenv.bat
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






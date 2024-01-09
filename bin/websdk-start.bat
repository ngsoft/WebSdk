@echo off
setlocal enabledelayedexpansion
pushd "%~dp0..\lib\sdk"
    echo.
    echo Starting WebSdk...
    echo.
    echo =====================================
    for %%f in (scripts\start-mariadb.bat scripts\start-cgi.bat scripts\start-nginx.bat) do (
        call "%%f"
    )
    call %~dp0adminer.bat
    echo =====================================
    echo.
popd
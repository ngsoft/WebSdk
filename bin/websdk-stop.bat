@echo off
setlocal enabledelayedexpansion
pushd "%~dp0..\lib\sdk"
    echo.
    echo Stopping WebSdk...
    echo.
    echo =====================================
    for %%f in (scripts\stop-nginx.bat scripts\stop-cgi.bat scripts\stop-mariadb.bat) do (
        call "%%f"
    )
    echo =====================================
    echo.
popd








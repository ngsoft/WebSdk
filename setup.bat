@echo off
echo Setting Up WebSdk ...

pushd "%~dp0lib\sdk"
    call .\setup.bat
    echo.
    echo Environment variables have been changed, so it is recommended that you restart your computer
    echo.
    pause
popd
@echo off
echo Setting Up WebSdk ...

pushd "%~dp0lib\sdk"
    call .\setup.bat
    pause
popd
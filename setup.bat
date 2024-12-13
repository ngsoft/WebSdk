@echo off


NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
%~dp0bin\elevate.exe cmd.exe /C "%~fx0"
goto :eof

:script
echo Setting Up WebSdk ...

pushd "%~dp0lib\sdk"
    call .\setup.bat
    @REM Update Env
    setx update true > NUL 2>&1
    reg delete HKCU\Environment /F /V update > NUL 2>&1
    echo.
    echo Environment variables have been changed, so it is recommended that you restart your computer
    echo.
    pause
popd
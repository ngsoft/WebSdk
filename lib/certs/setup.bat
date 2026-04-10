@echo off

if not exist "%~dp0cacert.pem" (
    echo Installing certs...
    call "%~dp0update.bat"
)

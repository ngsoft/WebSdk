@echo off

if not exist "%dp0cacert.pem" (
    echo Installing certs...
    pushd "%~dp0"
        %~dp0../../bin/wget.exe https://curl.haxx.se/ca/cacert.pem > certs.log 2>&1
    popd
)
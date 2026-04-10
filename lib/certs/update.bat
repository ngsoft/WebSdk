@echo off
pushd "%~dp0"
    if exist cacert.pem (
        del cacert.prev.pem > NUL 2>&1
        move /y cacert.pem cacert.prev.pem > NUL 2>&1
    )
    del cacert.pem > NUL 2>&1
    %~dp0../../bin/wget.exe https://curl.haxx.se/ca/cacert.pem > certs.log 2>&1
    if ERRORLEVEL 1 (
        copy /y cacert.prev.pem cacert.pem > NUL 2>&1
    )
popd

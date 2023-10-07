@echo off
setlocal
call "%~dp0stop-nginx.bat" > NUL 2>&1

call "%~dp0..\loadenv.bat"

pushd "%nginx%"
    echo Starting Nginx...
    "%SDK%daemonize.exe" .\nginx.exe
    start "" "http://localhost/phpmyadmin"
popd





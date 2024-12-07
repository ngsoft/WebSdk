@echo off

setlocal

call "%~dp0stop.bat"
call "%~dp0..\sdk\loadenv.bat"
taskkill /f /IM nginx.exe > NUL 2>&1
pushd "%~dp0bin"
    "%SDK%daemonize.exe" .\httpd.exe
popd


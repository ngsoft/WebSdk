@echo off

setlocal

taskkill /f /IM nginx.exe
taskkill /f /IM httpd.exe
taskkill /f /IM php-cgi.exe

call "%~dp0..\sdk\loadenv.bat"

pushd "%~dp0\bin"
    "%SDK%daemonize.exe" .\nginx.exe
popd
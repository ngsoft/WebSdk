@echo off
setlocal
call "%~dp0env.bat"
pushd "%~dp0bin" > NUL 2>&1
    start "" cmd.exe /K "echo MariaDB Console"
popd

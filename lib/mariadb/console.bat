@echo off
setlocal
pushd "%~dp0bin" > NUL 2>&1
    start "" cmd.exe /K "echo MariaDB Console"
popd

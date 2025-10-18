@echo off
setlocal
call "%~dp0env.bat"
pushd "%PG_ROOT%bin" > NUL 2>&1
    start "" cmd.exe /K "echo PostgreSql Console"
popd

@echo off
setlocal
pushd "%~dp0" > NUL 2>&1
    start "" cmd.exe /K "echo Redis Console (redis-cli) && redis-cli.exe"
popd

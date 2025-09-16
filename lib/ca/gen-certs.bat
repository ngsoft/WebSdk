@echo off
IF NOT "%~1" == "" goto main

:usage
echo gen-certs [domains]
exit /b 1
:main
pushd "%~dp0"
"%USERPROFILE%\go\bin\minica.exe" --domains "%~1" -ip-addresses 127.0.0.1
popd

@echo off
setlocal
call "%~dp0..\lib\sdk\loadenv.bat"
set "python=%py3%python.exe"
if EXIST "%python%" goto main
echo Seems python is not installed, please run installer
exit /b 1
:main
"%python%" %*
exit /b %ERRORLEVEL%
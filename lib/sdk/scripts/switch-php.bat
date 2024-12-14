@echo off
setlocal
set "php_version=%~1"

echo Switching PHP CGI to %php_version%

call "%~dp0start-cgi.bat"

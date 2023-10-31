@echo off
setlocal
call "%~dp0stop-cgi.bat" > NUL 2>&1
call "%~dp0..\loadenv.bat"
set "opts=-dmemory_limit=4G -dmax_execution_time=1000"

echo Starting PHP 8.2 FastCGI on port 9802...
"%SDK%daemonize.exe" "%php82%php-cgi.exe" -b 127.0.0.1:9802 %opts%
@REM echo Starting PHP 8.1 FastCGI...
@REM "%SDK%daemonize.exe" "%php81%php-cgi.exe" -b 127.0.0.1:9801 %opts%
@REM echo Starting PHP 7.4 FastCGI...
@REM "%SDK%daemonize.exe" "%php74%php-cgi.exe" -b 127.0.0.1:9704 %opts%
@REM echo Starting PHP 5.6 FastCGI...
@REM "%SDK%daemonize.exe" "%php56%php-cgi.exe" -b 127.0.0.1:9506 %opts%
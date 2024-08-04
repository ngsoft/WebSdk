@echo off
call "%~dp0common.bat"
@REM Options for PHP 64bits >=7.4
set "opts=-dmemory_limit=4G %opts%"
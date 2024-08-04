@echo off
@REM Uncomment next line to use more than 2G of ram
@REM set USE_ZEND_ALLOC=0
call "%~dp0common.bat"
@REM Options for PHP5 32bits  2G memory limit (set to 2000M to not hit the limit)
set "opts=-dmemory_limit=2048M %opts%"
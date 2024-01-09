@echo off

@REM Valid values 5.5, 5.6, 7.4, 8.1, 8.2
set "php_version=8.2"

@REM Options for PHP 64bits >=7.4
set "opts=-dmemory_limit=4G -dmax_execution_time=1000 -dpost_max_size=1050M -dupload_max_filesize=1024M"

@REM Options for PHP 32bits 5 2G (set to 2000M to not hit the limit) memory limit (no more for 32bit programs)
@REM set "opts=-dmemory_limit=2000M -dmax_execution_time=120 -dpost_max_size=128M -dupload_max_filesize=120M"


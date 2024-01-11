@echo off

@REM Options for PHP5 32bits  2G memory limit (set to 2000M to not hit the limit)
set "opts=-dmemory_limit=2000M -dmax_execution_time=1000 -dpost_max_size=1050M -dupload_max_filesize=1024M"
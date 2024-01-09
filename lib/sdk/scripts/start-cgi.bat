@echo off
setlocal
call "%~dp0stop-cgi.bat" > NUL 2>&1

@REM Loads Environment
call "%~dp0..\loadenv.bat"

if not defined opts (
    @REM Most compatible options (overridden by conf file)
    set "opts=-dmemory_limit=1024M -dmax_execution_time=120 -dpost_max_size=128M -dupload_max_filesize=120M"
)

if not defined php_version (
    @REM See this file for configuration
    call "%etc%php-cgi.bat"
)

echo Starting PHP %php_version% FastCGI on port 9802...
"%SDK%daemonize.exe" "%lib%php\%php_version%\php-cgi.exe" -b 127.0.0.1:9802 %opts%

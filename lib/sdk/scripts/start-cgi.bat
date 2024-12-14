@echo off
setlocal
@REM Loads Environment
call "%~dp0..\loadenv.bat"




if not defined opts (
    @REM Most compatible options (overridden by conf file)
    set "opts=-dmemory_limit=1024M -dmax_execution_time=120 -dpost_max_size=128M -dupload_max_filesize=120M"
)

if "%php_version%" == "" (
    @REM See this file for configuration
    call "%etc%php-cgi.bat"
)

if exist "%etc%php-cgi/%php_version%.bat" (
    call "%etc%php-cgi/%php_version%.bat"
)

echo Starting PHP %php_version% FastCGI on port 9802...

@REM Checks UAC
NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
@REM Run elevated
"%elevate%" "%sdk%daemonize.exe" cmd.exe /C "%~fx0"
goto :eof
:script
@REM Run Script Elevated

call "%~dp0stop-cgi.bat" > NUL 2>&1
pushd "%lib%php\%php_version%"
    "%sdk%daemonize.exe" php-cgi.exe -c .\php.ini -b 9802 %opts% 
popd

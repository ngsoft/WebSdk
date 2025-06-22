@echo off

setlocal 
call "%~dp0..\sdk\loadenv.bat"

@REM Checks UAC
NET FILE > NUL 2>&1
if "%ERRORLEVEL%" == "0" goto script
@REM Run elevated
"%elevate%" "%daemonize%" cmd.exe /C "%~fx0"
goto :eof

:error
echo minica.pem not found >&2
goto end

:script
@REM Run Script Elevated
pushd "%~dp0"
    if not exist minica.pem goto error
    echo Root certificate installation ...
    certutil.exe -addstore -f "ROOT" minica.pem
:end
popd


@echo off

if "%~1" == "install" (
    "%~dp0uv.exe" pip %* --system
    exit /b %ERRORLEVEL%
)
if "%~1" == "uninstall" (
    "%~dp0uv.exe" pip %* --system
    exit /b %ERRORLEVEL%
)
"%~dp0uv.exe" pip %*
exit /b %ERRORLEVEL%

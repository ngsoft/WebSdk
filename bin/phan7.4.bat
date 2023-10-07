@echo off
setlocal
call "%~dp0..\lib\sdk\getenv.bat"
"%php74%php.exe" "%sdk%phan.phar" -C  --unused-variable-detection  --redundant-condition-detection %*
echo.
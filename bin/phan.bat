@echo off
setlocal
set "PHP_ARGS=-dextension=ast"
set "PHAN_ARGS=-C  --unused-variable-detection  --redundant-condition-detection"
if not defined php (
    call "%~dp0..\lib\sdk\loadenv.bat"
)
"%php%php.exe" %PHP_ARGS% "%sdk%phan.phar" %PHAN_ARGS% %*
echo.
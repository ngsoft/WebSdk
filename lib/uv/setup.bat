@echo off

@REM NET FILE > NUL 2>&1
@REM if "%ERRORLEVEL%" == "0" goto main
@REM %~dp0..\..\bin\elevate.exe cmd.exe /C "%~fx0"
@REM goto :eof

goto main

:prepend_global_path [%1 - path, %2 - check] (
    if "%~1" == "" exit /b 1
    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b 1
        )
    )
    @REM Prepend to system path as microsoft store has a python executable
    @REM that launch the store
    reg query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        %sdk%regenv.exe set -nS -sp -x PATH "%~1" 2> NUL
        @REM set "PATH=%~1;%PATH%"
    )
    exit /b %ERRORLEVEL%
)

:add_path [%1 - path, %2 - check] (
    if "%~1" == "" exit /b 1
    if not exist "%~1" (
        if "%~2" neq "false" (
            exit /b 1
        )
    )

    reg query HKCU\Environment /v PATH | findstr /C:"%~1" > NUL 2>&1
    if ERRORLEVEL 1 (
        echo Adding %~1 to PATH
        %sdk%regenv.exe set -nU -sp -x PATH "%~1"
    )
    exit /b
)



:install_uv (
    echo Installing UV...
    set "UV_INSTALL_DIR=%~dp0bin"
    set "UV_PYTHON_BIN_DIR=%~dp0py"
    set "UV_PYTHON_INSTALL_DIR=%~dp0packages"
    set "pyuv=%~dp0packages\cpython-%pyversion%-windows-x86_64-none"
    setx UV_INSTALL_DIR "%UV_INSTALL_DIR%" > NUL 2>&1
    setx UV_PYTHON_BIN_DIR "%UV_PYTHON_BIN_DIR%" > NUL 2>&1
    setx UV_PYTHON_INSTALL_DIR "%UV_PYTHON_INSTALL_DIR%" > NUL 2>&1
    setx UV_BREAK_SYSTEM_PACKAGES true > NUL 2>&1
    call :add_path "%UV_INSTALL_DIR%" false
    @REM call :prepend_global_path "%UV_PYTHON_BIN_DIR%" false
    call :prepend_global_path "%~dp0packages\cpython-%pyversion%-windows-x86_64-none" false
    if ERRORLEVEL 1 (
        echo You must run this script as an administrator for it to work
        exit /b 1
    )
    call :prepend_global_path "%~dp0packages\cpython-%pyversion%-windows-x86_64-none\Scripts" false
    @REM call :add_path "%pyuv%" false
    @REM call :add_path "%pyuv%Scripts" false
    if not exist "%pyuv%\python.exe" (
        "%UV_INSTALL_DIR%\uv.exe" python install %pyversion% >  NUL 2>&1
        if not exist "%pyuv%\python.exe" (
            echo Python %pyversion% was not installed, please run setup again.
            exit /b 1
        )
        echo Installing/Updating essential modules ...
        "%pyuv%\python.exe" -m pip install --upgrade pip virtualenv pyinstaller pipupgrade --no-warn-script-location --break-system-packages
    )
    pause
    exit /b
)

:main

setlocal enabledelayedexpansion
call "%~dp0..\sdk\loadenv.bat"
call :install_uv


@REM UV_INSTALL_DIR=%lib%uv

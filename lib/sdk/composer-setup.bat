@echo off
goto main

:is_defined [%1 - Name] (
    if "%~1" == "" (
        exit /b 1
    )
    reg query HKCU\Environment /v "%~1" > NUL 2>&1
    exit /b %ERRORLEVEL%
)

:add_env [%1 - Name, %2 - Value] (
    if "%~1" == "" exit /b 1
    if "%~2" == "" exit /b 1

    echo Adding %~1 to environement
    @REM Register to User
    %sdk%regenv.exe set -nU -x "%~1" "%~2"
    @REM Set Current Environment
    set "%~1=%~2"
    exit /b
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
        %sdk%regenv.exe set -nU -sa -x PATH "%~1"
    )
    exit /b
)

:copy_conf [%1 - file] (
    if not exist "%~1" (
        exit /b 1
    )
    copy "%~1" "%varpath%" > NUL 2>&1
    exit /b
)


:set_config [%1 - VarName, %2 - RootPath] (
    if "%~1" == "" exit /b 1
    if "%~2" == "" exit /b 1
    set "varname=%~1"
    set "varpath=%~2"
    set "importconf=false"
    exit /b
)

:main
setlocal enabledelayedexpansion
call "%~dp0/loadenv.bat"
@REM Install Composer Environment
echo Setting up composer ...
call :set_config COMPOSER_HOME "%etc%composer"
@REM Import previous Composer Config
call :is_defined "%varname%"
if ERRORLEVEL 0 (
    @REM Check Local Environment
    if "%COMPOSER_HOME%" neq "" (
        if "%varpath%" neq "%COMPOSER_HOME%" (
            echo %varname% is already defined at %COMPOSER_HOME%, Importing configuration...
            set "importconf=true"
            for %%f in (composer.json composer.lock config.json auth.json) do (
                call :copy_conf "%COMPOSER_HOME%\%%f"
            )
        )
    )
)
@REM Setup new Environment
@REM Double escape to use variable name
call :add_path "%%%%COMPOSER_HOME%%%%\vendor\bin" false
@REM Updating COMPOSER_HOME
call :add_env "%varname%" "%varpath%"
if "%importconf%" == "true" (
    echo Running composer global install...
    %php%php.exe "%sdk%composer-setup.php"
    %php%php.exe %bin%composer.phar global install
)

@REM Setup LTS Version
echo Setting up composer LTS for PHP 5 ...
call :set_config COMPOSER_LTS_HOME "%etc%composer-lts"
call :add_env "%varname%" "%varpath%"
set "COMPOSER_HOME=%varpath%"
echo Running composer-lts global install...
%php55%php.exe %sdk%composer-lts.phar global install


@REM Install Adminer Autoloader
pushd "%WEB_SDK%var"
    %php55%php.exe %sdk%composer-lts.phar update
popd







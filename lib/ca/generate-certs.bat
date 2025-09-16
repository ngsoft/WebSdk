@echo off

setlocal enabledelayedexpansion
goto main

:to_lowercase [%1 - VariableName] (
    if "%~1" == "" exit /b 1
    SET %~1=!%~1:A=a!
    SET %~1=!%~1:B=b!
    SET %~1=!%~1:C=c!
    SET %~1=!%~1:D=d!
    SET %~1=!%~1:E=e!
    SET %~1=!%~1:F=f!
    SET %~1=!%~1:G=g!
    SET %~1=!%~1:H=h!
    SET %~1=!%~1:I=i!
    SET %~1=!%~1:J=j!
    SET %~1=!%~1:K=k!
    SET %~1=!%~1:L=l!
    SET %~1=!%~1:M=m!
    SET %~1=!%~1:N=n!
    SET %~1=!%~1:O=o!
    SET %~1=!%~1:P=p!
    SET %~1=!%~1:Q=q!
    SET %~1=!%~1:R=r!
    SET %~1=!%~1:S=s!
    SET %~1=!%~1:T=t!
    SET %~1=!%~1:U=u!
    SET %~1=!%~1:V=v!
    SET %~1=!%~1:W=w!
    SET %~1=!%~1:X=x!
    SET %~1=!%~1:Y=y!
    SET %~1=!%~1:Z=z!
    exit /b
)

:main
pushd "%~dp0"
set "hostname=%computername%"
call :to_lowercase hostname
echo Creating certificates for %hostname%, localhost
@REM "%USERPROFILE%\go\bin\minica.exe" --domains "%hostname%,%hostname%.local,*.%hostname%.local,localhost,localhost.local,*.localhost.local" -ip-addresses 127.0.0.1
call gen-certs.bat "%hostname%,%hostname%.local,*.%hostname%.local,localhost,localhost.local,*.localhost.local"
move /Y "%hostname%" localhost
call install-certs.bat
popd

@echo off
REM The script sets environment variables helpful for PostgreSQL
call "%~dp0../sdk/loadenv.bat"
SET "PG_ROOT=%~dp0%pgversion%\"
SET "PATH=%PG_ROOT%bin;%PATH%"
SET "PGDATA=%PG_ROOT%databases"
SET "PGLOCALEDIR=%PG_ROOT%share\locale"
SET "PGDATABASE=postgres"
SET "PGUSER=postgres"
SET "PGPORT=5432"

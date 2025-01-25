@echo off
REM The script sets environment variables helpful for PostgreSQL
SET "PATH=%~dp0bin;%PATH%"
SET "PGDATA=%~dp0databases"
SET "PGDATABASE=postgres"
SET "PGUSER=postgres"
SET "PGPORT=5432"
SET "PGLOCALEDIR=%~dp0share\locale"

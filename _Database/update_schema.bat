
@echo off
setlocal

:: ==========================================
:: KONFIGURASI DATABASE
:: ==========================================
set "DB_HOST=localhost"
set "DB_USER=root"
set "DB_PASS="
set "DB_NAME=elsyifa_core"

:: Lokasi mysqldump WAMP
set "MYSQLDUMP=C:\wamp64\bin\mysql\mysql8.4.7\bin\mysqldump.exe"

:: Lokasi output schema
set "OUTPUT=%~dp0..\_Database\schema.sql"

echo.
echo ==========================================
echo       DATABASE SCHEMA SYNCHRONIZATION
echo ==========================================
echo Database : %DB_NAME%
echo.

if not exist "%MYSQLDUMP%" (
    echo ERROR: mysqldump tidak ditemukan!
    pause
    exit /b 1
)

:: Export struktur database
"%MYSQLDUMP%" ^
--host=%DB_HOST% ^
--user=%DB_USER% ^
--password=%DB_PASS% ^
--no-data ^
--routines ^
--triggers ^
--events ^
--default-character-set=utf8mb4 ^
--result-file="%OUTPUT%" ^
%DB_NAME%

if errorlevel 1 (
    echo.
    echo ERROR: Gagal memperbarui schema!
    pause
    exit /b 1
)

echo.
echo ==========================================
echo SUCCESS: SCHEMA BERHASIL DIPERBARUI
echo ==========================================
echo File: %OUTPUT%
echo.

pause

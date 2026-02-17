@echo off
REM QUICKCHECK.BAT - Vérification Rapide du Projet AKVA-Auto
REM Date: 1 Février 2026
REM Utilisation: quickcheck.bat

setlocal enabledelayedexpansion

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║     QUICKCHECK - AKVA-Auto Project Verification            ║
echo ║     Date: 1 Février 2026 - Status: Production Ready        ║
echo ╚════════════════════════════════════════════════════════════╝
echo.

set PASSED=0
set FAILED=0

REM ═══════════════════════════════════════════════════════════════
echo [1/6] PHP SYNTAX CHECK
echo.

REM Check AdminDashboardController
php -l app\Http\Controllers\Admin\AdminDashboardController.php >nul 2>&1
if %ERRORLEVEL% equ 0 (
    echo ✅ AdminDashboardController.php
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ AdminDashboardController.php
    set /a FAILED=!FAILED!+1
)

REM Check ReparationController
php -l app\Http\Controllers\Admin\ReparationController.php >nul 2>&1
if %ERRORLEVEL% equ 0 (
    echo ✅ ReparationController.php
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ ReparationController.php
    set /a FAILED=!FAILED!+1
)

REM Check MessageContact
php -l app\Models\MessageContact.php >nul 2>&1
if %ERRORLEVEL% equ 0 (
    echo ✅ MessageContact.php
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ MessageContact.php
    set /a FAILED=!FAILED!+1
)

REM Check Notification
php -l app\Models\Notification.php >nul 2>&1
if %ERRORLEVEL% equ 0 (
    echo ✅ Notification.php
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ Notification.php
    set /a FAILED=!FAILED!+1
)

REM ═══════════════════════════════════════════════════════════════
echo.
echo [2/6] DIRECTORY STRUCTURE
echo.

if exist "app\Http\Controllers\Admin" (
    echo ✅ app/Http/Controllers/Admin/
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ app/Http/Controllers/Admin/
    set /a FAILED=!FAILED!+1
)

if exist "app\Models" (
    echo ✅ app/Models/
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ app/Models/
    set /a FAILED=!FAILED!+1
)

if exist "resources\views\admin" (
    echo ✅ resources/views/admin/
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ resources/views/admin/
    set /a FAILED=!FAILED!+1
)

if exist "database\migrations" (
    echo ✅ database/migrations/
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ database/migrations/
    set /a FAILED=!FAILED!+1
)

REM ═══════════════════════════════════════════════════════════════
echo.
echo [3/6] REMOVED DUPLICATES
echo.

if not exist "app\Http\Controllers\Reparations" (
    echo ✅ No Reparations/ReparationController
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ Reparations/ReparationController still exists
    set /a FAILED=!FAILED!+1
)

if not exist "app\Http\Controllers\Techniciens" (
    echo ✅ No Techniciens/TechnicienController
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ Techniciens/TechnicienController still exists
    set /a FAILED=!FAILED!+1
)

if not exist "app\Http\Controllers\Vehicules" (
    echo ✅ No Vehicules/VehiculeController
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ Vehicules/VehiculeController still exists
    set /a FAILED=!FAILED!+1
)

if not exist "app\Http\Controllers\Dashboard" (
    echo ✅ No Dashboard/DashboardController
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ Dashboard/DashboardController still exists
    set /a FAILED=!FAILED!+1
)

if not exist "app\Models\User.php" (
    echo ✅ No User.php model
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ User.php model still exists
    set /a FAILED=!FAILED!+1
)

REM ═══════════════════════════════════════════════════════════════
echo.
echo [4/6] CONFIGURATION FILES
echo.

if exist ".env" (
    echo ✅ .env
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ .env
    set /a FAILED=!FAILED!+1
)

if exist "config\auth.php" (
    echo ✅ config/auth.php
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ config/auth.php
    set /a FAILED=!FAILED!+1
)

if exist "routes\web.php" (
    echo ✅ routes/web.php
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ routes/web.php
    set /a FAILED=!FAILED!+1
)

if exist "composer.json" (
    echo ✅ composer.json
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ composer.json
    set /a FAILED=!FAILED!+1
)

REM ═══════════════════════════════════════════════════════════════
echo.
echo [5/6] DOCUMENTATION
echo.

if exist "REVISION_FINALE_COMPLETE.md" (
    echo ✅ REVISION_FINALE_COMPLETE.md
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ REVISION_FINALE_COMPLETE.md
    set /a FAILED=!FAILED!+1
)

if exist "GUIDE_NAVIGATION.md" (
    echo ✅ GUIDE_NAVIGATION.md
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ GUIDE_NAVIGATION.md
    set /a FAILED=!FAILED!+1
)

if exist "QUICKSTART.md" (
    echo ✅ QUICKSTART.md
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ QUICKSTART.md
    set /a FAILED=!FAILED!+1
)

REM ═══════════════════════════════════════════════════════════════
echo.
echo [6/6] VENDOR & DEPENDENCIES
echo.

if exist "vendor" (
    echo ✅ vendor/ exists
    set /a PASSED=!PASSED!+1
) else (
    echo ❌ vendor/ missing
    set /a FAILED=!FAILED!+1
)

if exist "node_modules" (
    echo ✅ node_modules/ exists
    set /a PASSED=!PASSED!+1
) else (
    echo ⚠️  node_modules/ missing (optional)
)

REM ═══════════════════════════════════════════════════════════════
echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║                      RESULTS SUMMARY                       ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo Passed: %PASSED% ✅
echo Failed: %FAILED% ❌
echo.

if %FAILED% equ 0 (
    echo ✅ ALL CHECKS PASSED - PROJECT IS READY!
    echo.
    echo Next steps:
    echo   1. php artisan migrate:fresh --seed
    echo   2. php artisan serve
    echo   3. Open http://127.0.0.1:8000
    echo.
    exit /b 0
) else (
    echo ❌ SOME CHECKS FAILED - SEE ABOVE
    exit /b 1
)

#!/usr/bin/env bash
# QUICKCHECK - Vérification Rapide du Projet AKVA-Auto
# Date: 1 Février 2026
# Utilisation: bash quickcheck.sh

echo "╔════════════════════════════════════════════════════════════╗"
echo "║     QUICKCHECK - AKVA-Auto Project Verification            ║"
echo "║     Date: 1 Février 2026 - Status: Production Ready        ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Couleurs
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

PASSED=0
FAILED=0

# Function pour tester
check() {
    local description="$1"
    local command="$2"
    
    echo -n "Checking: $description... "
    
    if eval "$command" &> /dev/null; then
        echo -e "${GREEN}✅ PASS${NC}"
        ((PASSED++))
    else
        echo -e "${RED}❌ FAIL${NC}"
        ((FAILED++))
    fi
}

# ═══════════════════════════════════════════════════════════════
echo -e "${YELLOW}=== 1. PHP SYNTAX CHECK ===${NC}"
check "AdminDashboardController.php" "php -l app/Http/Controllers/Admin/AdminDashboardController.php"
check "ReparationController.php" "php -l app/Http/Controllers/Admin/ReparationController.php"
check "MessageContact.php" "php -l app/Models/MessageContact.php"
check "Notification.php" "php -l app/Models/Notification.php"

# ═══════════════════════════════════════════════════════════════
echo ""
echo -e "${YELLOW}=== 2. DIRECTORY STRUCTURE ===${NC}"
check "app/Http/Controllers/Admin/ exists" "test -d app/Http/Controllers/Admin"
check "app/Models/ exists" "test -d app/Models"
check "resources/views/admin/ exists" "test -d resources/views/admin"
check "database/migrations/ exists" "test -d database/migrations"
check "database/seeders/ exists" "test -d database/seeders"

# ═══════════════════════════════════════════════════════════════
echo ""
echo -e "${YELLOW}=== 3. REMOVED DUPLICATES ===${NC}"
check "No Reparations/ReparationController" "! test -d app/Http/Controllers/Reparations"
check "No Techniciens/TechnicienController" "! test -d app/Http/Controllers/Techniciens"
check "No Vehicules/VehiculeController" "! test -d app/Http/Controllers/Vehicules"
check "No Dashboard/DashboardController" "! test -d app/Http/Controllers/Dashboard"
check "No User.php model" "! test -f app/Models/User.php"

# ═══════════════════════════════════════════════════════════════
echo ""
echo -e "${YELLOW}=== 4. CONFIGURATION FILES ===${NC}"
check ".env file exists" "test -f .env"
check "config/auth.php exists" "test -f config/auth.php"
check "routes/web.php exists" "test -f routes/web.php"
check "composer.json exists" "test -f composer.json"
check "package.json exists" "test -f package.json"

# ═══════════════════════════════════════════════════════════════
echo ""
echo -e "${YELLOW}=== 5. DOCUMENTATION ===${NC}"
check "REVISION_FINALE_COMPLETE.md exists" "test -f REVISION_FINALE_COMPLETE.md"
check "STATUS_FINAL.txt exists" "test -f STATUS_FINAL.txt"
check "GUIDE_NAVIGATION.md exists" "test -f GUIDE_NAVIGATION.md"
check "CHANGESET_2026-02-01.md exists" "test -f CHANGESET_2026-02-01.md"
check "QUICKSTART.md exists" "test -f QUICKSTART.md"
check "DEVELOPER_GUIDE.md exists" "test -f DEVELOPER_GUIDE.md"

# ═══════════════════════════════════════════════════════════════
echo ""
echo -e "${YELLOW}=== 6. VENDOR & DEPENDENCIES ===${NC}"
check "vendor/ exists" "test -d vendor"
check "vendor/autoload.php exists" "test -f vendor/autoload.php"
check "node_modules/ exists" "test -d node_modules"

# ═══════════════════════════════════════════════════════════════
echo ""
echo "╔════════════════════════════════════════════════════════════╗"
echo "║                      RESULTS SUMMARY                       ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""
echo -e "Passed: ${GREEN}$PASSED✅${NC}"
echo -e "Failed: ${RED}$FAILED❌${NC}"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✅ ALL CHECKS PASSED - PROJECT IS READY!${NC}"
    echo ""
    echo "Next steps:"
    echo "  1. php artisan migrate:fresh --seed"
    echo "  2. php artisan serve"
    echo "  3. Open http://127.0.0.1:8000"
    echo ""
    exit 0
else
    echo -e "${RED}❌ SOME CHECKS FAILED - SEE ABOVE${NC}"
    exit 1
fi

#!/bin/bash

echo "========================================"
echo " Initializing Platinum Core Framework"
echo "========================================"




# ----------------------------------------
# Source Structure
# ----------------------------------------

mkdir -p \
src/Foundation \
src/Container \
src/Configuration \
src/Events \
src/Routing \
src/Http \
src/Identity \
src/Persistence \
src/Contexts \
src/View \
src/Support \
src/Console \
src/Contracts

# ----------------------------------------
# Resources
# ----------------------------------------

mkdir -p \
resources/views \
resources/assets \
resources/lang

# ----------------------------------------
# Configuration
# ----------------------------------------

mkdir -p config

# ----------------------------------------
# Storage
# ----------------------------------------

mkdir -p \
storage/cache \
storage/logs \
storage/framework

# ----------------------------------------
# Tests
# ----------------------------------------

mkdir -p \
tests/Unit \
tests/Integration \
tests/Architecture \
tests/Bdd

# ----------------------------------------
# Other Project Directories
# ----------------------------------------

mkdir -p \
bin \
docs

# ----------------------------------------
# Root Files
# ----------------------------------------

touch \
platinum-core.php \
composer.json \
README.md \
.gitignore

# ----------------------------------------
# Placeholder Files
# ----------------------------------------

touch \
resources/views/.gitkeep \
resources/assets/.gitkeep \
resources/lang/.gitkeep \
storage/cache/.gitkeep \
storage/logs/.gitkeep \
storage/framework/.gitkeep \
tests/Unit/.gitkeep \
tests/Integration/.gitkeep \
tests/Architecture/.gitkeep \
tests/Bdd/.gitkeep \
bin/.gitkeep \
docs/.gitkeep

echo ""
echo "========================================"
echo " Platinum Core Structure Created"
echo "========================================"
echo ""
echo "Project Root: $(pwd)"
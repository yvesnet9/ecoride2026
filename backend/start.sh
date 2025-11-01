#!/bin/sh
echo "📦 Lancement du backend Ecoride sur Render..."
echo "📁 Dossier courant : $(pwd)"
ls -la
echo "========================================"
php -S 0.0.0.0:10000 -t . router.php


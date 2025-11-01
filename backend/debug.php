<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>✅ PHP fonctionne sur Render</h2>";

echo "<p><strong>Current directory:</strong> " . getcwd() . "</p>";

if (file_exists(__DIR__ . '/api/test.php')) {
    echo "<p>✅ Le fichier <code>api/test.php</code> existe bien.</p>";
} else {
    echo "<p>❌ Le fichier <code>api/test.php</code> est introuvable.</p>";
}

echo "<hr><h3>phpinfo()</h3>";
phpinfo();


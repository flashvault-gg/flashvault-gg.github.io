<?php

// Simple password (change this to anything you want)

$password = "wave@flashvault";

// Check if password is provided

if (!isset($_GET['p']) || $_GET['p'] !== $password) {

    die("Access Denied");

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>FlashVault Logs</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

        body {

            background: #000;

            color: #fff;

            font-family: 'Courier New', monospace;

            padding: 20px;

            margin: 0;

        }

        .container {

            max-width: 1200px;

            margin: 0 auto;

        }

        h1 {

            color: #0066FF;

            border-bottom: 1px solid #333;

            padding-bottom: 10px;

            font-size: 24px;

        }

        h1 span {

            color: #FFD700;

            font-size: 14px;

            display: block;

            margin-top: 5px;

        }

        .logs {

            background: #111;

            border: 1px solid #333;

            padding: 20px;

            border-radius: 8px;

            white-space: pre-wrap;

            font-size: 14px;

            line-height: 1.6;

            max-height: 70vh;

            overflow-y: auto;

        }

        .refresh {

            background: #0066FF;

            color: white;

            border: none;

            padding: 10px 20px;

            border-radius: 4px;

            cursor: pointer;

            margin-bottom: 20px;

            font-size: 14px;

        }

        .refresh:hover {

            background: #0052cc;

        }

        .stats {

            color: #00ffaa;

            margin-bottom: 15px;

            padding: 10px;

            background: #1a1a1a;

            border-radius: 4px;

            display: inline-block;

        }

        .clear-btn {

            background: #ff4444;

            color: white;

            border: none;

            padding: 10px 20px;

            border-radius: 4px;

            cursor: pointer;

            margin-left: 10px;

            font-size: 14px;

        }

        .clear-btn:hover {

            background: #cc0000;

        }

        .footer {

            margin-top: 20px;

            color: #666;

            font-size: 12px;

            text-align: center;

        }

    </style>

</head>

<body>

    <div class="container">

        <h1>🔐 FlashVault Login Logs <span>flashvault.fwh.is</span></h1>

        

        <?php

        // Count entries

        $count = 0;

        if (file_exists('logins.txt')) {

            $content = file_get_contents('logins.txt');

            $count = substr_count($content, '========================================');

        }

        ?>

        <div class="stats">📊 Total Logins: <?php echo $count; ?></div>

        

        <button class="refresh" onclick="location.reload()">🔄 Refresh</button>

        <button class="clear-btn" onclick="if(confirm('Clear all logs?')) window.location.href='clear.php?p=<?php echo $password; ?>'">🗑️ Clear Logs</button>

        

        <div class="logs">

            <?php

            if (file_exists('logins.txt')) {

                $logs = file_get_contents('logins.txt');

                if (empty($logs)) {

                    echo "No logins yet...";

                } else {

                    // Show latest first (reverse order)

                    $entries = explode("========================================\n", $logs);

                    $entries = array_reverse(array_filter($entries));

                    foreach ($entries as $entry) {

                        if (!empty(trim($entry))) {

                            echo "<div style='margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px;'>";

                            echo nl2br(htmlspecialchars("========================================\n" . $entry));

                            echo "</div>";

                        }

                    }

                }

            } else {

                echo "Log file not created yet. First login will create it.";

            }

            ?>

        </div>

        

        <div class="footer">

            <a href="?p=<?php echo $password; ?>" style="color: #0066FF; text-decoration: none;">↻ Refresh</a> | 

            <span>flashvault.fwh.is</span>

        </div>

    </div>

</body>

</html>
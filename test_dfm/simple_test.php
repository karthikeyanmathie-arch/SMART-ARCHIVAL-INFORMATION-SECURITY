<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Test</title>
</head>
<body>
    <h1>Simple Test Page</h1>
    <p>This is a test to see if HTML renders properly.</p>
    <p>Current time: <?php echo date('Y-m-d H:i:s'); ?></p>
    
    <h2>Navigation Test</h2>
    <ul>
        <li><a href="welcome.php">Welcome Page</a></li>
        <li><a href="login.php">Login Page</a></li>
        <li><a href="index.php">Main Dashboard</a></li>
        <li><a href="diagnostic.php">Diagnostic Page</a></li>
    </ul>
    
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: white; }
        h1 { color: blue; }
        h2 { color: green; }
        p { margin: 10px 0; }
        a { color: blue; text-decoration: underline; }
    </style>
</body>
</html>

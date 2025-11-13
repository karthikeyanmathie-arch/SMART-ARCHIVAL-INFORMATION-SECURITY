<?php
$error_code = isset($_GET['error']) ? $_GET['error'] : '404';

$errors = [
    '404' => [
        'title' => 'Page Not Found',
        'message' => 'The page you are looking for could not be found.',
        'description' => 'The requested URL was not found on this server.'
    ],
    '403' => [
        'title' => 'Access Forbidden',
        'message' => 'You do not have permission to access this resource.',
        'description' => 'Access to this resource is restricted.'
    ],
    '500' => [
        'title' => 'Internal Server Error',
        'message' => 'An internal server error occurred.',
        'description' => 'Please try again later or contact the administrator.'
    ]
];

$error = isset($errors[$error_code]) ? $errors[$error_code] : $errors['404'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $error['title']; ?> - Document Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-card {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 1rem;
        }
        .error-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #666;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-code"><?php echo $error_code; ?></div>
            <h1 class="error-title"><?php echo $error['title']; ?></h1>
            <p class="error-message"><?php echo $error['message']; ?></p>
            <p style="color: #999; margin-bottom: 2rem;"><?php echo $error['description']; ?></p>
            <a href="index.php" class="btn btn-primary">Return to Dashboard</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
        </div>
    </div>
</body>
</html>
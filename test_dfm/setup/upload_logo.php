<?php
// Admin logo upload utility
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Only allow admin users
if (!isset($_SESSION['user_id']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')) {
    // If not logged in, show a simple form that redirects to login
    echo "<p>You must be logged in as an admin to upload the logo. <a href='/test_dfm/login.php'>Login</a></p>";
    exit;
}

$message = '';
if (
    isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK
) {
    $allowed = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg', 'image/x-icon' => 'ico'];
    $tmpName = $_FILES['logo']['tmp_name'];
    $mime = mime_content_type($tmpName);

    if (!array_key_exists($mime, $allowed)) {
        $message = 'Unsupported file type. Please upload PNG or JPG image.';
    } else {
        $ext = $allowed[$mime];
        $targetDir = __DIR__ . '/../assets/images/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        // Standard filename used by header and favicon
        $targetFile = $targetDir . 'ssm_logo.' . $ext;
        $publicPath = '/test_dfm/assets/images/ssm_logo.' . $ext;

        if (move_uploaded_file($tmpName, $targetFile)) {
            // Also create a copy with fixed name ssm_logo.png for consistency if image is jpg convert? We'll attempt copy if png/jpg
            if ($ext === 'png') {
                copy($targetFile, $targetDir . 'ssm_logo.png');
            } elseif ($ext === 'jpg') {
                // try to create png copy if gd available
                if (function_exists('imagecreatefromjpeg') && function_exists('imagepng')) {
                    $img = imagecreatefromjpeg($targetFile);
                    if ($img) {
                        imagepng($img, $targetDir . 'ssm_logo.png');
                        imagedestroy($img);
                    }
                } else {
                    // fallback: copy original as jpg and also as ssm_logo.png if possible
                    copy($targetFile, $targetDir . 'ssm_logo.jpg');
                }
            }

            $message = 'Logo uploaded successfully. It will be used across the site (refresh pages or clear browser cache to see favicon).';
        } else {
            $message = 'Failed to move uploaded file. Check folder permissions.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload College Logo</title>
    <link rel="stylesheet" href="/test_dfm/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <div class="main-container">
        <h1>Upload College Logo</h1>
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="logo">Choose logo (PNG or JPG, ideally square)</label>
                <input type="file" name="logo" id="logo" accept="image/png,image/jpeg,image/jpg,image/x-icon" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <p style="margin-top:1rem;">Or manually place your file at <code>assets/images/ssm_logo.png</code> (recommended filename).</p>
        <p><a href="/test_dfm/index.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
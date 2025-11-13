<?php
/**
 * System Requirements Checker
 * Checks if the server meets all requirements for the application
 */

$requirements = [
    'PHP Version' => [
        'required' => '7.4.0',
        'current' => PHP_VERSION,
        'status' => version_compare(PHP_VERSION, '7.4.0', '>=')
    ],
    'PDO Extension' => [
        'required' => 'Enabled',
        'current' => extension_loaded('pdo') ? 'Enabled' : 'Disabled',
        'status' => extension_loaded('pdo')
    ],
    'PDO MySQL Extension' => [
        'required' => 'Enabled',
        'current' => extension_loaded('pdo_mysql') ? 'Enabled' : 'Disabled',
        'status' => extension_loaded('pdo_mysql')
    ],
    'Fileinfo Extension' => [
        'required' => 'Enabled',
        'current' => extension_loaded('fileinfo') ? 'Enabled' : 'Disabled',
        'status' => extension_loaded('fileinfo')
    ],
    'GD Extension' => [
        'required' => 'Enabled',
        'current' => extension_loaded('gd') ? 'Enabled' : 'Disabled',
        'status' => extension_loaded('gd')
    ]
];

$directories = [
    'uploads' => '../uploads',
    'config' => '../config',
    'assets' => '../assets'
];

$allPassed = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requirements Check - Smart Archival & Information System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .requirement-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #e1e5e9;
        }
        .status-pass { color: #28a745; font-weight: bold; }
        .status-fail { color: #dc3545; font-weight: bold; }
        .requirement-details { font-size: 0.9rem; color: #666; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card" style="max-width: 700px;">
            <h2 class="login-title">System Requirements Check</h2>
            
            <div class="content-card" style="margin: 0; padding: 1.5rem;">
                <h3>PHP Requirements</h3>
                <?php foreach ($requirements as $name => $req): ?>
                    <?php if (!$req['status']) $allPassed = false; ?>
                    <div class="requirement-item">
                        <div>
                            <strong><?php echo $name; ?></strong>
                            <div class="requirement-details">
                                Required: <?php echo $req['required']; ?> | 
                                Current: <?php echo $req['current']; ?>
                            </div>
                        </div>
                        <div class="<?php echo $req['status'] ? 'status-pass' : 'status-fail'; ?>">
                            <?php echo $req['status'] ? '✓ PASS' : '✗ FAIL'; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <h3 style="margin-top: 2rem;">Directory Permissions</h3>
                <?php foreach ($directories as $name => $path): ?>
                    <?php 
                    $exists = file_exists($path);
                    $writable = $exists && is_writable($path);
                    if (!$exists || !$writable) $allPassed = false;
                    ?>
                    <div class="requirement-item">
                        <div>
                            <strong><?php echo ucfirst($name); ?> Directory</strong>
                            <div class="requirement-details">
                                Path: <?php echo $path; ?> | 
                                <?php if (!$exists): ?>
                                    Directory does not exist
                                <?php elseif (!$writable): ?>
                                    Directory is not writable
                                <?php else: ?>
                                    Directory exists and is writable
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="<?php echo ($exists && $writable) ? 'status-pass' : 'status-fail'; ?>">
                            <?php echo ($exists && $writable) ? '✓ PASS' : '✗ FAIL'; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <h3 style="margin-top: 2rem;">PHP Configuration</h3>
                <?php
                $phpConfig = [
                    'file_uploads' => [
                        'name' => 'File Uploads',
                        'value' => ini_get('file_uploads') ? 'Enabled' : 'Disabled',
                        'status' => ini_get('file_uploads')
                    ],
                    'upload_max_filesize' => [
                        'name' => 'Max Upload Size',
                        'value' => ini_get('upload_max_filesize'),
                        'status' => true
                    ],
                    'post_max_size' => [
                        'name' => 'Max POST Size',
                        'value' => ini_get('post_max_size'),
                        'status' => true
                    ],
                    'max_execution_time' => [
                        'name' => 'Max Execution Time',
                        'value' => ini_get('max_execution_time') . ' seconds',
                        'status' => true
                    ]
                ];
                ?>
                <?php foreach ($phpConfig as $config): ?>
                    <div class="requirement-item">
                        <div>
                            <strong><?php echo $config['name']; ?></strong>
                            <div class="requirement-details">
                                Current: <?php echo $config['value']; ?>
                            </div>
                        </div>
                        <div class="<?php echo $config['status'] ? 'status-pass' : 'status-fail'; ?>">
                            <?php echo $config['status'] ? '✓ OK' : '✗ ISSUE'; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 2rem; text-align: center;">
                    <?php if ($allPassed): ?>
                        <div class="alert alert-success">
                            ✓ All requirements met! You can proceed with installation.
                        </div>
                        <a href="install.php" class="btn btn-primary">Start Installation</a>
                    <?php else: ?>
                        <div class="alert alert-error">
                            ✗ Some requirements are not met. Please fix the issues above before proceeding.
                        </div>
                        <button onclick="location.reload()" class="btn btn-secondary">Recheck Requirements</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
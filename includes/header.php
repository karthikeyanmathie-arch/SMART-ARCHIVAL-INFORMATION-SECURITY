<?php
// Determine avatar source: look for uploaded avatar in uploads/users/{id}.{ext}
$avatarSrc = '';
$defaultInitial = isset($_SESSION['username']) && strlen($_SESSION['username']) ? strtoupper($_SESSION['username'][0]) : 'U';
$defaultSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24"><rect fill="#6b21a8" width="24" height="24" rx="3"/><text x="50%" y="50%" fill="#ffffff" dy=".35em" font-family="Poppins, Arial, sans-serif" font-size="10" text-anchor="middle">'.htmlspecialchars($defaultInitial).'</text></svg>';
$defaultDataUri = 'data:image/svg+xml;utf8,'.rawurlencode($defaultSvg);
$avatarSrc = $defaultDataUri;

$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    $docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], "\\/");
    $extensions = ['png','jpg','jpeg','webp','gif'];
    foreach ($extensions as $ext) {
        $filePath = $docRoot . '/test_dfm/uploads/users/' . $userId . '.' . $ext;
        if (file_exists($filePath)) {
            $avatarSrc = '/test_dfm/uploads/users/' . $userId . '.' . $ext;
            break;
        }
    }
}
?>
<header class="header">
    <div class="header-content">
        <div class="logo-container">
            <!-- College Logo -->
            <img src="/test_dfm/assets/images/college_logo.jpg" alt="SSM College Logo" class="logo-img">
            <div class="logo-text">
                <h1>Smart Archival & Information System</h1>
                <div class="college-name">SSM COLLEGE OF ARTS AND SCIENCE DINDIGUL-624002</div>
            </div>
        </div>
        <div class="user-info">
            <a href="/test_dfm/profile.php" title="View profile" class="avatar-link"><img src="<?php echo $avatarSrc; ?>" alt="Profile" class="avatar-img"></a>
            <span>Welcome, <a href="/test_dfm/profile.php" style="color: var(--text-primary); text-decoration: underline;"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></a></span>
            <span>|</span>
            <span><?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Visitor'; ?></span>
            <span>|</span>
            <span><?php echo isset($_SESSION['department']) ? $_SESSION['department'] : 'General'; ?></span>
            <button class="view-toggle" id="viewToggle" title="Toggle Desktop/Mobile View" aria-label="Toggle viewport mode" style="position: static; margin-left: var(--spacing-md);">
                <svg id="viewIcon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Desktop icon by default -->
                    <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                    <line x1="2" y1="17" x2="22" y2="17" stroke="currentColor" stroke-width="2"/>
                </svg>
            </button>
            <div class="theme-toggle" id="themeToggle" style="position: static; margin-left: var(--spacing-md);">
                <svg id="themeIcon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3V4M12 20V21M4 12H3M6.34315 6.34315L5.63604 5.63604M17.6569 6.34315L18.364 5.63604M6.34315 17.6569L5.63604 18.364M17.6569 17.6569L18.364 18.364M21 12H20M16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <a href="/test_dfm/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>
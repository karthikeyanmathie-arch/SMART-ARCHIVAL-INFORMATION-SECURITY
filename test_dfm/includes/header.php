<header class="header">
    <div class="header-content">
        <div class="logo-container">
            <!-- Place your college logo at assets/images/ssm_logo.png -->
            <img src="/test_dfm/assets/images/ssm_logo.png" alt="SSM College Logo" class="logo-img" onerror="this.style.display='none'">
            <div class="logo-text">
                <h1>Smart Archival & Information System</h1>
                <div class="college-name">SSM COLLEGE OF ARTS AND SCIENCE DINDIGUL-624002</div>
            </div>
        </div>
        <div class="user-info">
            <span>Welcome, <a href="/test_dfm/profile.php" style="color: #fff; text-decoration: underline;"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></a></span>
            <span>|</span>
            <span><?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Visitor'; ?></span>
            <span>|</span>
            <span><?php echo isset($_SESSION['department']) ? $_SESSION['department'] : 'General'; ?></span>
            <a href="/test_dfm/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>
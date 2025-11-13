<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dept_file_management');

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbh;
    private $error;

    public function __construct() {
        // Try different password combinations for XAMPP
        $passwords = ['', 'root', 'password'];
        $connected = false;
        
        foreach ($passwords as $test_pass) {
            try {
                $dsn = 'mysql:host=' . $this->host;
                $this->dbh = new PDO($dsn, $this->user, $test_pass, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ));
                
                // If we get here, connection worked
                $this->pass = $test_pass;
                $connected = true;
                break;
                
            } catch(PDOException $e) {
                // Try next password
                continue;
            }
        }
        
        if (!$connected) {
            $this->error = "Cannot connect to MySQL. Make sure XAMPP is running and MySQL service is started.";
            $this->dbh = null;
            echo "<div style='color: red; margin: 10px; padding: 10px; border: 1px solid red;'>";
            echo "<strong>Database Connection Error:</strong><br>";
            echo $this->error . "<br><br>";
            echo "<strong>Quick Solutions:</strong><br>";
            echo "1. <strong>Start XAMPP:</strong> Open XAMPP Control Panel and start MySQL<br>";
            echo "2. <strong>Auto-fix:</strong> <a href='fix_mysql.php' style='color: blue; font-weight: bold;'>Click here for automatic diagnosis and fix</a><br>";
            echo "3. <strong>Manual fix:</strong> <a href='setup_database.php'>Setup Database</a> | <a href='test_connection.php'>Test Connection</a><br>";
            echo "</div>";
            return;
        }
        
        try {
            // Check if database exists
            $stmt = $this->dbh->query("SHOW DATABASES LIKE '" . $this->dbname . "'");
            if ($stmt->rowCount() == 0) {
                // Database doesn't exist, create it
                $this->dbh->exec("CREATE DATABASE IF NOT EXISTS " . $this->dbname);
            }
            
            // Now connect to the specific database
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            $this->dbh = null;
            
            // Display helpful error message
            echo "<div style='color: red; margin: 10px; padding: 10px; border: 1px solid red;'>";
            echo "<strong>Database Connection Error:</strong><br>";
            echo $e->getMessage() . "<br><br>";
            echo "<strong>Possible solutions:</strong><br>";
            echo "1. Make sure XAMPP is running<br>";
            echo "2. Start MySQL service in XAMPP Control Panel<br>";
            echo "3. Check if database credentials are correct<br>";
            echo "</div>";
        }
    }

    /**
     * Return the active PDO connection.
     *
     * @return PDO
     * @throws Exception when connection failed
     */
    public function getConnection(): PDO {
        if ($this->dbh === null) {
            throw new Exception("Database connection failed: " . $this->error);
        }
        return $this->dbh;
    }

    /**
     * Return the active PDO connection.
     *
     * @return PDO
     * @throws Exception when connection failed
     */
    public function getConnectionTyped(): PDO {
        if ($this->dbh === null) {
            throw new Exception("Database connection failed: " . $this->error);
        }
        return $this->dbh;
    }

    public function getError() {
        return $this->error;
    }
}
?>

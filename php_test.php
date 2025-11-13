<?php
// Ultra-simple test to check if PHP is working
echo "<!DOCTYPE html>";
echo "<html><head><title>PHP Test</title></head><body>";
echo "<h1 style='color: green;'>✅ PHP is working!</h1>";
echo "<p><strong>Date/Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "</body></html>";
?>

@echo off
echo ====================================
echo       XAMPP MySQL Starter
echo ====================================
echo.

echo Checking if XAMPP is installed...
if exist "C:\xampp\xampp_start.exe" (
    echo Found XAMPP installation
    echo.
    echo Starting XAMPP services...
    echo.
    
    echo Starting Apache...
    C:\xampp\apache\bin\httpd.exe -k start
    
    echo Starting MySQL...
    C:\xampp\mysql\bin\mysqld.exe --defaults-file=C:\xampp\mysql\bin\my.ini --standalone --console
    
    echo.
    echo Services started! You can now access your application at:
    echo http://localhost/shrii/
    echo.
) else (
    echo XAMPP not found at C:\xampp\
    echo Please install XAMPP or update the path in this script
    echo.
)

echo Press any key to continue...
pause > nul
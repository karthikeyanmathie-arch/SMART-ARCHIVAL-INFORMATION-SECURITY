# Script to add favicon to all PHP files
$faviconLine = '    <link rel="icon" type="image/jpeg" href="/test_dfm/assets/images/college_logo.jpg">'
$files = Get-ChildItem -Path "c:\xampp\htdocs\test_dfm" -Filter "*.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    # Check if file has <head> tag and doesn't already have favicon
    if ($content -match '<head>' -and $content -notmatch 'college_logo.jpg') {
        # Find the position after <title> tag
        if ($content -match '(<title>.*?</title>\r?\n)') {
            $newContent = $content -replace '(<title>.*?</title>\r?\n)', "`$1$faviconLine`n"
            Set-Content -Path $file.FullName -Value $newContent -NoNewline
            Write-Host "Updated: $($file.FullName)"
        }
    }
}

Write-Host "`nDone! Favicon added to all PHP files."

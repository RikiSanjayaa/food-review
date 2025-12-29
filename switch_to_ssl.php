<?php
$path = '.env';
$content = file_get_contents($path);

// Switch back to smtp
$content = preg_replace("/^MAIL_MAILER=.*/m", "MAIL_MAILER=smtp", $content);

// Change Port to 465
$content = preg_replace("/^MAIL_PORT=.*/m", "MAIL_PORT=465", $content);

// Change Encryption to ssl
$content = preg_replace("/^MAIL_ENCRYPTION=.*/m", "MAIL_ENCRYPTION=ssl", $content);

file_put_contents($path, $content);
echo "Switched SMTP to Port 465 (SSL).";

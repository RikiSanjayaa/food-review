<?php
$path = '.env';
$content = file_get_contents($path);

// Switch to log driver
$content = preg_replace("/^MAIL_MAILER=.*/m", "MAIL_MAILER=log", $content);

// Comment out SMTP config to be safe (optional, but keeps it clean in logs)
// $content = preg_replace("/^MAIL_HOST=.*/m", "# MAIL_HOST=smtp.gmail.com", $content);

file_put_contents($path, $content);
echo "Switched MAIL_MAILER to log.";

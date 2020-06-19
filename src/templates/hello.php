<?php
$content = ($name ?? '') . " " . ($extra ?? '');
echo "Hello " . ucfirst(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));

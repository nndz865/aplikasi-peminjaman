<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/app.php';
generate_csrf_token();

require_once __DIR__ . '/../routes/web.php';

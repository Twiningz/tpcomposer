<?php

$title = 'logout page';

ob_start();

$content = ob_get_clean();

require($_SERVER['DOCUMENT_ROOT'] . '/views/layouts/layout.php');

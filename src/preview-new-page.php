<?php
function clean_title(&$string)
{
    $clean = trim(str_replace(" ", '_', strip_tags($string)));
    return (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        str_tolower($clean);
}
// data to return
$data = [];

// html from preview used to make new html file
$html_data = $_POST['html'];

// where to store the new html pages
$dir = __DIR__ . '/pages';

if (is_dir($dir) === false) {
    try {
        mkdir($dir, 0776);
    } catch (Exception $e) {
        $data['error'] = $e->getMessage();
        $success = false;
    }
}

if (isset($_POST['title'])) {
    $title = clean_title($_POST['title']);
    $data['title'] = $title;
} else {
    // unique prefix for file names
    $uniqprefix = bin2hex(openssl_random_pseudo_bytes(8)) . '-';
    $title = $uniqprefix . 'DEFAULT';
}


// Build HTML structure
$html = <<<HTML
<!doctype html>
<head lang="en">
<meta charset="UTF-8"/>
<title>{$title}</title>
</head>
<html>
<body>
{$html_data}
</body>
</html>
HTML;

// write html to file
try {
    $filename = $dir . '/' . $title . '.html';
    file_put_contents($filename, $html);
    $data['save_as_name'] = $filename;
    $success = true;
} catch (Exception $e) {
    $data['error'] += $e->getMessage();
    $success = false;
}
$data['success'] = $success;

echo json_encode($data);

<?php
require_once '../vendor/autoload.php';

$parser = new \cebe\markdown\GithubMarkdown();
$editor = 'iotastic-editor';
$data = [];

if (isset($_POST[$editor])) {
    $data['editor'] = $parser->parse($_POST[$editor]);
    echo $data['editor']; 
}

<?php
// Init
error_reporting(NULL);
session_start();
$TAB = 'SEARCH';
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check query
$q = $_GET['q'];
if (empty($q)) {
    $back=getenv("HTTP_REFERER");
    if (!empty($back)) {
        header("Location: ".$back);
        exit;
    }
    header("Location: /");
    exit;
}

// Header
include($_SERVER['DOCUMENT_ROOT'].'/templates/header.html');

// Panel
top_panel($user,$TAB);

// Data
if ($_SESSION['user'] == 'admin') {
    $q = escapeshellarg($q);
    exec (VESTA_CMD."v_search_object ".$q." json", $output, $return_var);
    $data = json_decode(implode('', $output), true);
    include($_SERVER['DOCUMENT_ROOT'].'/templates/admin/list_search.html');
} else {
    exec (VESTA_CMD."v_list_web_domains $user json", $output, $return_var);
    $data = json_decode(implode('', $output), true);
    include($_SERVER['DOCUMENT_ROOT'].'/templates/user/list_web.html');
}

// Footer
include($_SERVER['DOCUMENT_ROOT'].'/templates/footer.html');
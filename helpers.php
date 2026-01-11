<?php
if(session_status()===PHP_SESSION_NONE) session_start();

function redirect($url){ header("Location: $url"); exit; }

function is_logged_in(){ return isset($_SESSION['user']) && !empty($_SESSION['user']['id']); }

function require_login(){ if(!is_logged_in()) redirect('login.php'); }

function require_librarian(){ require_login(); if($_SESSION['user']['role']!=='librarian') redirect('dashboard.php'); }

function require_member(){ require_login(); if($_SESSION['user']['role']!=='member') redirect('dashboard.php'); }

function e($s){ return htmlspecialchars($s,ENT_QUOTES,'UTF-8'); }
?>

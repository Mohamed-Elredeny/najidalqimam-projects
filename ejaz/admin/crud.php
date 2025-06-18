<?php
// admin/crud.php
session_start();
require_once __DIR__ . '/../config/db.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
$module = $_GET['module'] ?? 'dashboard';
$action = $_GET['action'] ?? 'list';
$allowed = [
    'dashboard'=>['list'],
    'projects'=>['list','add','edit','view','delete'],
    // …
];
if (!isset($allowed[$module]) || !in_array($action,$allowed[$module])) {
    http_response_code(404);
    exit('Not found');
}
require __DIR__.'/../includes/header.php';
include __DIR__."/{$module}/{$action}.php";
require __DIR__ . '/../includes/footer.php';

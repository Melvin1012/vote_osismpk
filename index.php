<?php
require_once "controller/VotingController.php";

$controller = new VotingController();
$action = $_GET['action'] ?? '';

switch ($action) {

    // GURU
    case 'insert_guru':
        $controller->insert_guru();
        break;
    case 'view_guru':
        $controller->view_guru();
        break;

    // SISWA
    case 'insert_siswa':
        $controller->insert_siswa();
        break;
    case 'view_siswa':
        $controller->view_siswa();
        break;

    default:
        echo json_encode([
            "status" => false,
            "message" => "Endpoint tidak ditemukan"
        ]);
        // ================= KANDIDAT =================
    case 'insert_kandidat':
        $controller->insert_kandidat();
        break;
    case 'view_kandidat':
        $controller->view_kandidat();
        break;

    // ================= USER =================
    case 'insert_user':
        $controller->insert_user();
        break;
    case 'view_user':
        $controller->view_user();
        break;

    // ================= VOTING =================
    case 'voting':
        $controller->voting();
        break;
    case 'hasil_voting':
        $controller->hasil_voting();
        break;
}

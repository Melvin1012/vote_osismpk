<?php
require_once "config/database.php";
require_once "model/VotingModel.php";
require_once "helper/response.php";

class VotingController
{
    private $model;

    public function __construct()
    {
        $db = new Database();
        $this->model = new VotingModel($db->connect());
    }

    private function getInput()
    {
        return json_decode(file_get_contents("php://input"), true);
    }

    // ================= GURU =================

    public function insert_guru()
    {
        $data = $this->getInput();
        $this->model->insert_guru($data)
            ? jsonResponse(true, "Guru berhasil ditambahkan")
            : jsonResponse(false, "Gagal");
    }

    public function view_guru()
    {
        jsonResponse(true, "Data guru", $this->model->get_guru());
    }

    // ================= SISWA =================

    public function insert_siswa()
    {
        $data = $this->getInput();
        $this->model->insert_siswa($data)
            ? jsonResponse(true, "Siswa berhasil ditambahkan")
            : jsonResponse(false, "Gagal");
    }

    public function view_siswa()
    {
        jsonResponse(true, "Data siswa", $this->model->get_siswa());
    }

    // ================= KANDIDAT =================

    public function insert_kandidat()
    {
        $data = $this->getInput();
        $this->model->insert_kandidat($data)
            ? jsonResponse(true, "Kandidat ditambahkan")
            : jsonResponse(false, "Gagal");
    }

    public function view_kandidat()
    {
        jsonResponse(true, "Data kandidat", $this->model->get_kandidat());
    }

    // ================= USER =================

    public function insert_user()
    {
        $data = $this->getInput();
        $this->model->insert_user($data)
            ? jsonResponse(true, "User dibuat")
            : jsonResponse(false, "Gagal");
    }

    public function view_user()
    {
        jsonResponse(true, "Data user", $this->model->get_user());
    }

    // ================= VOTING =================

    public function voting()
    {
        $data = $this->getInput();
        $result = $this->model->voting($data);

        if ($result['status']) {
            jsonResponse(true, "Voting berhasil");
        } else {
            jsonResponse(false, $result['message']);
        }
    }

    public function hasil_voting()
    {
        $id = $_GET['id_periode'] ?? 0;
        jsonResponse(true, "Hasil voting", $this->model->hasil_voting($id));
    }
}
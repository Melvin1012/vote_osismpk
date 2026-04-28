<?php 
class VotingModel {
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    // ================= GURU =================

    public function insert_guru($data)
    {
        $stmt = $this->db->prepare("CALL sp_tambah_guru(:nip, :nama, :email, :jk)");
        $result = $stmt->execute([
            ":nip"   => $data['nip'],
            ":nama"  => $data['nama_guru'],
            ":email" => $data['email'],
            ":jk"    => $data['jenis_kelamin']
        ]);
        $stmt->closeCursor();
        return $result;
    }

    public function get_guru()
    {
        return $this->db->query("SELECT * FROM m_guru")->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= SISWA =================

    public function insert_siswa($data)
    {
        $stmt = $this->db->prepare("CALL sp_tambah_siswa(:nipd, :nama, :email, :jk)");
        $result = $stmt->execute([
            ":nipd"  => $data['nipd'],
            ":nama"  => $data['nama_siswa'],
            ":email" => $data['email'],
            ":jk"    => $data['jenis_kelamin']
        ]);
        $stmt->closeCursor();
        return $result;
    }

    public function get_siswa()
    {
        return $this->db->query("SELECT * FROM m_siswa")->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= KANDIDAT =================

    public function insert_kandidat($data)
    {
        $stmt = $this->db->prepare("CALL sp_tambah_kandidat(:ketua, :wakil, :periode, :jenis, :visi, :misi)");
        $result = $stmt->execute([
            ":ketua"   => $data['id_ketua'],
            ":wakil"   => $data['id_wakil'],
            ":periode" => $data['id_periode'],
            ":jenis"   => $data['jenis'],
            ":visi"    => $data['visi'],
            ":misi"    => $data['misi']
        ]);
        $stmt->closeCursor();
        return $result;
    }

    public function get_kandidat()
    {
        return $this->db->query("
            SELECT k.*, s1.nama_siswa AS ketua, s2.nama_siswa AS wakil
            FROM m_kandidat k
            LEFT JOIN m_siswa s1 ON k.id_ketua = s1.id_siswa
            LEFT JOIN m_siswa s2 ON k.id_wakil = s2.id_siswa
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= USER =================

    public function insert_user($data)
    {
        $stmt = $this->db->prepare("CALL sp_tambah_user(:username, :password, :role, :tipe, :id_guru, :id_siswa)");
        $result = $stmt->execute([
            ":username" => $data['username'],
            ":password" => $data['password'],
            ":role"     => $data['role'],
            ":tipe"     => $data['tipe_user'],
            ":id_guru"  => $data['id_guru'] ?? null,
            ":id_siswa" => $data['id_siswa'] ?? null
        ]);
        $stmt->closeCursor();
        return $result;
    }

    public function get_user()
    {
        return $this->db->query("SELECT * FROM m_users")->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= VOTING =================

    public function voting($data)
    {
        $stmt = $this->db->prepare("CALL sp_voting(:user, :kandidat, :periode)");
        try {
            $stmt->execute([
                ":user"     => $data['id_user'],
                ":kandidat" => $data['id_kandidat'],
                ":periode"  => $data['id_periode']
            ]);
            $stmt->closeCursor();
            return ["status" => true];
        } catch (PDOException $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    public function hasil_voting($id_periode)
    {
        $stmt = $this->db->prepare("CALL sp_hasil_voting(:periode)");
        $stmt->execute([":periode" => $id_periode]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }
}
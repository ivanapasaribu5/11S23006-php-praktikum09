<?php
require_once (__DIR__ . '/../config.php');

class TodoModel
{
    private $conn;

    public function __construct()
    {
        // Inisialisasi koneksi database PostgreSQL
        $this->conn = pg_connect('host=' . DB_HOST . ' port=' . DB_PORT . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASSWORD);
        if (!$this->conn) {
            die('Koneksi database gagal');
        }
    }

    public function __destruct()
    {
        // Menutup koneksi saat objek dihancurkan
        // Ini akan memastikan transaksi di-commit sebelum koneksi ditutup
        pg_close($this->conn);
    }

    public function getAllTodos($filter = 'all', $search = '')
    {
        $query = 'SELECT * FROM todo';
        $params = [];
        $conditions = [];
        $param_count = 1;

        // Tambahkan kondisi WHERE berdasarkan filter
        if ($filter === 'finished') {
            $conditions[] = 'is_finished = true';
        } elseif ($filter === 'unfinished') {
            $conditions[] = 'is_finished = false';
        }

        // Tambahkan kondisi WHERE untuk pencarian jika ada
        if (!empty($search)) {
            $conditions[] = '(title ILIKE $' . $param_count . ' OR description ILIKE $' . $param_count . ')';
            $params[] = '%' . $search . '%';
            $param_count++;
        }

        // Gabungkan semua kondisi dengan 'AND'
        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        // Selalu urutkan berdasarkan yang terbaru
        $query .= ' ORDER BY created_at DESC';

        // Jalankan query dengan parameter
        $result = pg_query_params($this->conn, $query, $params);
        $todos = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                // Konversi boolean postgres ('t'/'f') ke boolean PHP untuk konsistensi
                $row['is_finished'] = ($row['is_finished'] === 't');
                $todos[] = $row;
            }
        }
        return $todos;
    }

    public function isTitleExists($title, $excludeId = null)
    {
        // Gunakan ILIKE untuk pencarian case-insensitive, sesuai dengan pencarian
        $query = 'SELECT id FROM todo WHERE title ILIKE $1';
        $params = [$title];

        if ($excludeId !== null) {
            $query .= ' AND id != $2';
            $params[] = (int)$excludeId;
        }

        $query .= ' LIMIT 1';

        $result = pg_query_params($this->conn, $query, $params);

        if ($result && pg_num_rows($result) > 0) {
            return true; // Judul sudah ada
        }

        return false; // Judul belum ada
    }

    public function getTodoById($id)
    {
        $query = 'SELECT * FROM todo WHERE id = $1 LIMIT 1';
        $result = pg_query_params($this->conn, $query, [(int)$id]);

        if ($result && pg_num_rows($result) > 0) {
            $todo = pg_fetch_assoc($result);
            // Konversi boolean postgres ('t'/'f') ke boolean PHP
            $todo['is_finished'] = ($todo['is_finished'] === 't');
            return $todo;
        }

        return false; // Return false jika tidak ditemukan
    }

    public function createTodo($title, $description)
    {
        // Menambahkan created_at dan updated_at ke query
        // Sekarang gunakan kolom 'title' yang sudah benar
        $query = 'INSERT INTO todo (title, description, created_at, updated_at) VALUES ($1, $2, NOW(), NOW())';
        $result = pg_query_params($this->conn, $query, [$title, $description]);
        return $result !== false;
    }

    public function updateTodo($id, $title, $description, $is_finished)
    {
        // Konversi boolean PHP ke string 'true'/'false' untuk PostgreSQL
        $pg_bool = $is_finished ? 'true' : 'false'; // $is_finished didapat dari parameter baru
        // Query ini sudah benar, menggunakan 'title'
        $query = 'UPDATE todo SET title=$1, description=$2, is_finished=$3, updated_at=NOW() WHERE id=$4';
        $result = pg_query_params($this->conn, $query, [$title, $description, $pg_bool, $id]); // Gunakan parameter yang benar
        return $result !== false;
    }

    public function deleteTodo($id)
    {
        $query = 'DELETE FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        return $result !== false;
    }
}

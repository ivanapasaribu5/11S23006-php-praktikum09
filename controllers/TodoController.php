<?php
require_once (__DIR__ . '/../models/TodoModel.php');

class TodoController
{
    public function index()
    {
        // Ambil nilai filter dari URL, defaultnya 'all'
        $filter = isset($_GET['filter']) ? trim($_GET['filter']) : 'all';
        // Ambil nilai pencarian dari URL, defaultnya string kosong
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $todoModel = new TodoModel();
        $todos = $todoModel->getAllTodos($filter, $search); // Kirim filter dan search ke model
        include (__DIR__ . '/../views/TodoView.php');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi input: pastikan title tidak kosong dan bersihkan input
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';

            $todoModel = new TodoModel();
            // Validasi: Judul tidak boleh kosong dan tidak boleh duplikat
            if (!empty($title) && !$todoModel->isTitleExists($title)) {
                if ($todoModel->createTodo($title, $description)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Todo berhasil ditambahkan.'];
                } else {
                    $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Gagal menambahkan todo.'];
                }
            } else {
                $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Gagal: Judul tidak boleh kosong atau sudah ada.'];
            }
        }
        header('Location: index.php');
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // Pastikan ID adalah integer
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            // Konversi '0' atau '1' dari form ke boolean PHP
            $is_finished = isset($_POST['is_finished']) && $_POST['is_finished'] === '1';

            $todoModel = new TodoModel();
            // Validasi: ID valid, judul tidak kosong, dan judul tidak duplikat (kecuali untuk ID saat ini)
            if ($id > 0 && !empty($title) && !$todoModel->isTitleExists($title, $id)) {
                if ($todoModel->updateTodo($id, $title, $description, $is_finished)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Todo berhasil diperbarui.'];
                } else {
                    $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Gagal memperbarui todo.'];
                }
            } else {
                $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Gagal: Judul tidak boleh kosong atau sudah digunakan oleh todo lain.'];
            }
        }
        header('Location: index.php');
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Pastikan ID adalah integer
            if ($id > 0) {
                $todoModel = new TodoModel();
                if ($todoModel->deleteTodo($id)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Todo berhasil dihapus.'];
                } else {
                    $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Gagal menghapus todo.'];
                }
            }
        }
        header('Location: index.php');
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    }
}

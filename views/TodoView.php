<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Todolist Premium</title>
    <!-- Link Bootstrap Icons untuk icon (tetap diperlukan) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1c2541 0%, #0b132b 100%);
            min-height: 100vh;
            padding: 2rem;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        /* Header Section - Separate from card */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.8s ease-out;
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .page-header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }
        .page-header p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Top Action Bar */
        .action-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            animation: slideInUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: grab;
            border: 2px solid transparent;
        }
        .btn {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
        }
        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }
        .btn-secondary:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }
        
        .search-filter-group {
            display: flex;
            gap: 1rem;
            flex: 1;
            max-width: 600px;
        }
        
        /* Filter Buttons */
        .filter-section {
            display: flex;
            gap: 0.5rem;
        }
        .btn-filter {
            padding: 0.75rem 1.5rem;
            border: 2px solid transparent;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        .btn-filter:hover {
            background: #e2e8f0;
            color: #475569;
            transform: translateY(-2px);
        }
        .btn-filter.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Search Box */
        .search-box {
            display: flex;
            gap: 0.5rem;
            flex: 1;
        }
        .search-box input {
            flex: 1;
            padding: 0.75rem 1.25rem;
            border: 2px solid #e2e8f0;
            background: #ffffff;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.3s ease;
        }
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .search-box input::placeholder {
            color: #94a3b8;
        }
        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: #ffffff;
            padding: 0.75rem 1.5rem;
        }
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        }
        
        /* Alert Messages */
        .alert {
            padding: 1.25rem 1.75rem;
            border-radius: 14px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            border-left: 4px solid;
            font-weight: 500;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            border-color: #22c55e;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-color: #ef4444;
        }
        .btn-close {
            background: transparent;
            border: 0;
            opacity: 0.5;
            cursor: pointer;
            font-size: 1.5rem;
            line-height: 1;
            color: inherit;
        }
        .btn-close:hover {
            opacity: 1;
        }
        
        /* Todo Grid Layout */
        .todo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .todo-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: grab;
            border: 2px solid transparent;
        }
        .todo-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }
        .todo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            border-radius: 20px 20px 0 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .todo-card-ghost {
            opacity: 0.4;
            border-style: dashed;
        }
        
        .todo-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }
        .todo-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
            flex: 1;
        }
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
        }
        .badge-danger {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
        }
        
        .todo-description {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .todo-meta {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .todo-actions {
            display: flex;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }
        .btn-sm {
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            flex: 1;
            justify-content: center;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }
        .btn-outline {
            background: transparent;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }
        .btn-outline:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        .empty-state p {
            font-size: 1.1rem;
            color: #64748b;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal.fade.show {
            display: flex;
            animation: modalFadeIn 0.3s ease-out;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-dialog {
            background: #ffffff;
            border-radius: 20px;
            /* Menambahkan margin auto untuk memastikan posisi tengah */
            margin-top: auto;
            margin-bottom: auto;
            /* --- */
            max-width: 550px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .modal-content {
            background: transparent;
            border: none;
        }
        .modal-header {
            padding: 2rem 2rem 1rem;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h5 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .modal-body {
            padding: 1rem 2rem 2rem;
            color: #374151;
        }
        .modal-footer {
            padding: 1rem 2rem 2rem;
            border-top: none;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .mb-3 {
            margin-bottom: 1.5rem;
        }
        input, textarea, select, .form-control {
            display: block;
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        input::placeholder, textarea::placeholder {
            color: #94a3b8;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        select, .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
            appearance: none;
        }
        .modal-body .modal-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
        }
        .detail-badge-container {
            margin-bottom: 1.5rem;
        }
        .detail-section {
            margin-bottom: 1.5rem;
        }
        .detail-section h6 {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }
        .detail-section p {
            color: #475569;
            line-height: 1.6;
        }
        .detail-meta-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 1rem;
        }
        .detail-meta-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: #f8fafc;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .detail-meta-list i {
            font-size: 1.25rem;
            color: #7dd3fc;
            margin-top: 0.125rem;
        }
        .detail-meta-list strong {
            display: block;
            font-weight: 700;
            color: #1e293b;
            font-size: 0.9rem;
        }
        
        [data-bs-theme=dark] .modal-dialog {
            background: #1f2937;
            border: 1px solid #4b5563;
        }
        [data-bs-theme=dark] .modal-header, [data-bs-theme=dark] .modal-footer {
            border-color: #374151;
        }
        [data-bs-theme=dark] .modal-body .modal-title, [data-bs-theme=dark] .modal-header h5 {
            color: #f9fafb;
        }
        [data-bs-theme=dark] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .page-header h1 {
                font-size: 2.5rem;
            }
            .page-header p {
                font-size: 1rem;
            }
            .action-bar {
                flex-direction: column;
                padding: 1.25rem;
            }
            .search-filter-group {
                flex-direction: column;
                width: 100%;
                max-width: 100%;
            }
            .filter-section {
                width: 100%;
                flex-wrap: wrap;
            }
            .search-box {
                width: 100%;
            }
            .todo-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>✨ My Todo List</h1>
        <p>Kelola tugas Anda dengan mudah dan efisien</p>
    </div>
    
    <?php
    // Tampilkan flash message jika ada
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        echo '<div class="alert alert-' . $flash['type'] . ' alert-dismissible fade show" role="alert">';
        echo '<span>' . ($flash['type'] == 'success' ? '✓' : '✗') . ' ' . $flash['message'] . '</span>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>';
        echo '</div>';
        unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan
    }
    ?>

    <?php
    $current_filter = $_GET['filter'] ?? 'all';
    $current_search = $_GET['search'] ?? '';
    $search_query_param = !empty($current_search) ? '&search=' . urlencode($current_search) : '';
    ?>

    <!-- Action Bar -->
    <div class="action-bar">
        <div class="search-filter-group">
            <div class="filter-section">
                <a href="index.php?filter=all<?= $search_query_param ?>" class="btn-filter <?= $current_filter == 'all' ? 'active' : '' ?>">Semua</a>
                <a href="index.php?filter=unfinished<?= $search_query_param ?>" class="btn-filter <?= $current_filter == 'unfinished' ? 'active' : '' ?>">Aktif</a>
                <a href="index.php?filter=finished<?= $search_query_param ?>" class="btn-filter <?= $current_filter == 'finished' ? 'active' : '' ?>">Selesai</a>
            </div>
            <form action="index.php" method="GET" class="search-box">
                <input type="hidden" name="filter" value="<?= htmlspecialchars($current_filter) ?>">
                <input type="text" name="search" placeholder="Cari tugas..." value="<?= htmlspecialchars($current_search) ?>">
                <button type="submit" class="btn btn-info">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodo">
            <i class="bi bi-plus-lg"></i> Tambah Tugas
        </button>
    </div>
    
    <!-- Todo Grid -->
    <div id="todo-list-body" class="todo-grid">
        <?php if (!empty($todos)): ?>
            <?php foreach ($todos as $i => $todo): ?>
            <div class="todo-card" data-id="<?= $todo['id'] ?>"
                data-title="<?= htmlspecialchars($todo['title']) ?>"
                data-description="<?= htmlspecialchars($todo['description']) ?>"
                data-is-finished="<?= $todo['is_finished'] ? '1' : '0' ?>"
                data-created-at="<?= date('d M Y, H:i:s', strtotime($todo['created_at'])) ?>"
                data-updated-at="<?= date('d M Y, H:i:s', strtotime($todo['updated_at'])) ?>">
                
                <div class="todo-card-header">
                    <h3 class="todo-title"><?= htmlspecialchars($todo['title']) ?></h3>
                    <?php if ($todo['is_finished']): ?>
                        <span class="badge badge-success">Selesai</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Aktif</span>
                    <?php endif; ?>
                </div>
                <p class="todo-description"><?= nl2br(htmlspecialchars($todo['description'])) ?></p>
                <div class="todo-meta">
                    <i class="bi bi-clock"></i>
                    <span>Diperbarui: <?= date('d M Y, H:i', strtotime($todo['updated_at'])) ?></span>
                </div>
                <div class="todo-actions">
                    <button class="btn btn-sm btn-warning btn-edit" title="Ubah">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline btn-detail" title="Detail">
                        <i class="bi bi-eye"></i> Detail
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-journal-x"></i>
                <p>Belum ada data tersedia! Mulailah dengan menambahkan tugas baru.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL ADD TODO (Struktur Modal Bootstrap dipertahankan) -->
<div class="modal fade" id="addTodo" tabindex="-1" aria-labelledby="addTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoLabel">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Tugas Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <form action="?page=create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="title" id="inputTitle" placeholder="Contoh: Belajar PHP" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="inputDescription" rows="4" placeholder="Tuliskan deskripsi tugas..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT TODO (Struktur Modal Bootstrap dipertahankan) -->
<div class="modal fade" id="editTodo" tabindex="-1" aria-labelledby="editTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTodoLabel">
                    <i class="bi bi-pencil-square"></i> Ubah Tugas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="inputEditTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEditTitle" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="title" id="inputEditTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="inputEditDescription" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="selectEditIsFinished" class="form-label">Status</label>
                        <select class="form-select" name="is_finished" id="selectEditIsFinished">
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE TODO (Struktur Modal Bootstrap dipertahankan) -->
<div class="modal fade" id="deleteTodo" tabindex="-1" aria-labelledby="deleteTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTodoLabel">
                    <i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    Kamu akan menghapus todo <strong id="deleteTodoTitle" style="color: #dc2626;"></strong>.
                    Apakah kamu yakin?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <!-- Menggunakan kelas btn-danger kustom -->
                <a id="btnDeleteTodo" class="btn btn-danger">Ya, Tetap Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL TODO (Struktur Modal Bootstrap dipertahankan) -->
<div class="modal fade" id="detailTodo" tabindex="-1" aria-labelledby="detailTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTodoLabel">
                    <i class="bi bi-card-text"></i> Detail Tugas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <!-- 1. Judul -->
                <h5 class="modal-title" id="detailTodoTitle" style="margin-bottom: 1.5rem;"></h5>

                <!-- 2. Deskripsi -->
                <div class="detail-section">
                    <h6>Deskripsi</h6>
                    <p id="detailTodoDescription"></p>
                </div>

                <!-- 3. Status -->
                <div class="detail-section">
                    <h6>Status</h6>
                    <span id="detailTodoStatus"></span>
                </div>

                <!-- 4. Informasi -->
                <div class="detail-section">
                    <h6>Informasi</h6>
                    <ul class="detail-meta-list">
                        <li>
                            <i class="bi bi-calendar-plus"></i>
                            <div>
                                <strong>Dibuat pada:</strong>
                                <span id="detailTodoCreatedAt"></span>
                            </div>
                        </li>
                        <li>
                            <i class="bi bi-calendar-check"></i>
                            <div>
                                <strong>Diperbarui pada:</strong>
                                <span id="detailTodoUpdatedAt"></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Script tetap diperlukan untuk fungsionalitas Modals dan Drag/Drop -->
<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const todoListBody = document.getElementById('todo-list-body');
    const storageKey = 'todoOrder';

    // Inisialisasi Modals
    // Menggunakan konstruktor Modal dari Bootstrap JS
    const editModalElement = document.getElementById("editTodo");
    const deleteModalElement = document.getElementById("deleteTodo");
    const detailModalElement = document.getElementById("detailTodo");
    
    // Pastikan elemen ditemukan sebelum membuat instance
    let editModal, deleteModal, detailModal;
    if (editModalElement) editModal = new bootstrap.Modal(editModalElement);
    if (deleteModalElement) deleteModal = new bootstrap.Modal(deleteModalElement);
    if (detailModalElement) detailModal = new bootstrap.Modal(detailModalElement);


    // Event delegation untuk tombol-tombol aksi
    todoListBody.addEventListener('click', function(event) {
        const target = event.target;
        // Mencari tombol aksi terdekat
        const button = target.closest('.btn-edit, .btn-delete, .btn-detail');

        if (!button) return;

        // Mengambil data dari elemen todo-item terdekat
        const row = button.closest('.todo-card');
        if (!row) return; // Tambahkan pengaman jika row tidak ditemukan
        
        const todoId = row.dataset.id;
        const title = row.dataset.title;
        const description = row.dataset.description;
        const isFinished = row.dataset.isFinished;
        const createdAt = row.dataset.createdAt;
        const updatedAt = row.dataset.updatedAt;

        if (button.classList.contains('btn-edit') && editModal) {
            document.getElementById("inputEditTodoId").value = todoId;
            document.getElementById("inputEditTitle").value = title;
            document.getElementById("inputEditDescription").value = description; 
            document.getElementById("selectEditIsFinished").value = isFinished;
            editModal.show();
        }

        if (button.classList.contains('btn-delete') && deleteModal) {
            document.getElementById("deleteTodoTitle").innerText = title;
            document.getElementById("btnDeleteTodo").setAttribute("href", `?page=delete&id=${todoId}`);
            deleteModal.show();
        }

        if (button.classList.contains('btn-detail') && detailModal) {
            document.getElementById("detailTodoTitle").innerText = title;
            
            const descElement = document.getElementById("detailTodoDescription");
            // Mengganti newline karakter (\n) dengan <br> agar terlihat benar di modal detail
            descElement.innerHTML = description.trim() ? description.replace(/\n/g, '<br>') : '<em>Tidak ada deskripsi yang diberikan.</em>';

            const statusElement = document.getElementById("detailTodoStatus");
            statusElement.innerHTML = isFinished === '1'
                ? '<span class="badge badge-success">Selesai</span>' 
                : '<span class="badge badge-danger">Aktif</span>';

            document.getElementById("detailTodoCreatedAt").innerText = createdAt;
            document.getElementById("detailTodoUpdatedAt").innerText = updatedAt;

            detailModal.show();
        }
    });

    // Fungsi untuk menyimpan urutan ke localStorage
    function saveOrder() {
        const todoIds = Array.from(todoListBody.children)
            .map(row => row.getAttribute('data-id'))
            .filter(id => id); // Filter out null/empty ids (misal: baris 'data tidak ada')
        if (todoIds.length === 0) {
            localStorage.removeItem(storageKey);
            return;
        }
        localStorage.setItem(storageKey, JSON.stringify(todoIds));
    }

    // Fungsi untuk memuat dan menerapkan urutan dari localStorage
    function loadOrder() {
        // Jangan load order jika ada filter atau pencarian aktif, karena datanya tidak lengkap
        const urlParams = new URLSearchParams(window.location.search);
        // Memastikan hanya memuat urutan jika filter='all' atau filter tidak ada sama sekali DAN tidak ada pencarian
        if ((urlParams.get('filter') && urlParams.get('filter') !== 'all') || urlParams.get('search')) {
            return;
        }

        const savedOrder = localStorage.getItem(storageKey);
        if (savedOrder) {
            const todoIds = JSON.parse(savedOrder);
            const rows = Array.from(todoListBody.children);
            const sortedRows = [];

            // Buat peta untuk pencarian cepat
            const rowsMap = new Map(rows.filter(row => row.dataset.id).map(row => [row.getAttribute('data-id'), row]));

            // Urutkan baris sesuai ID yang tersimpan
            todoIds.forEach(id => {
                if (rowsMap.has(id)) {
                    sortedRows.push(rowsMap.get(id));
                    rowsMap.delete(id); // Hapus dari peta agar tidak terduplikasi
                }
            });

            // Tambahkan baris baru yang belum ada di urutan tersimpan (jika ada)
            const remainingRows = Array.from(rowsMap.values());
            const finalRows = sortedRows.concat(remainingRows);

            // Terapkan urutan baru ke DOM
            todoListBody.innerHTML = ''; // Kosongkan body
            finalRows.forEach(row => todoListBody.appendChild(row));
        }
    }

    // Muat urutan saat halaman dibuka
    loadOrder();

    // Inisialisasi SortableJS hanya jika tidak ada filter atau pencarian aktif
    const urlParams = new URLSearchParams(window.location.search);
    if ((!urlParams.has('filter') || urlParams.get('filter') === 'all') && !urlParams.has('search')) {
        new Sortable(todoListBody, {
            animation: 150,
            ghostClass: 'todo-card-ghost',
            onEnd: saveOrder
        });
    }
});
</script>
</body>
</html>

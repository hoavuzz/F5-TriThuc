<div class="profile-container">
    <h2>👨‍🏫 Thông tin giáo viên</h2>

    <?php if (!empty($success)): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Hiển thị thông tin -->
    <div id="profile-info">
        <p><strong>ID:</strong> <?= $user['user_id'] ?></p>
        <p><strong>Tên:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? '') ?></p>
        <p><strong>Vai trò:</strong> <?= htmlspecialchars($user['role']) ?></p>
        <p><strong>Trạng thái:</strong>
            <?= $user['status'] == 1 ? "<span class='active'>Hoạt động</span>" : "<span class='pending'>Chờ duyệt</span>" ?>
        </p>
        <p><strong>Ngày tạo:</strong> <?= $user['created_at'] ?></p>
        <p><strong>Cập nhật:</strong> <?= $user['updated_at'] ?></p>

        <?php if (!empty($user['avatar_url'])): ?>
            <div class="avatar-box">
                <img src="../uploads/avatars/<?= $user['avatar_url'] ?>" alt="Avatar">
            </div>
        <?php endif; ?>

        <?php if (!empty($user['teacher_file'])): ?>
            <p><strong>File chứng minh:</strong>
                <a href="../uploads/teachers/<?= $user['teacher_file'] ?>" target="_blank">Xem file</a>
            </p>
        <?php endif; ?>

        <button id="edit-btn">✏️ Chỉnh sửa thông tin</button>
    </div>

    <!-- Form chỉnh sửa -->
    <form method="POST" id="edit-form" class="update-form" style="display:none;" enctype="multipart/form-data">
        <label>Tên</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Số điện thoại</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

        <label>Ảnh đại diện</label>
        <input type="file" name="avatar">

        <label>File chứng minh (PDF/Ảnh)</label>
        <input type="file" name="teacher_file">

        <div class="form-actions">
            <button type="submit">💾 Lưu thay đổi</button>
            <button type="button" id="cancel-btn" class="cancel">Hủy</button>
        </div>
    </form>

    <hr>

    <h3>📚 Khóa học của tôi</h3>
    <a class="btn-add" href="index.php?mod=course&act=add">➕ Thêm khóa học</a>

    <?php if (!empty($myCourses)): ?>
        <ul class="course-list">
            <?php foreach ($myCourses as $c): ?>
                <li>
                    <a href="index.php?mod=course&act=detail&id=<?= $c['course_id'] ?>">
                        <strong><?= htmlspecialchars($c['name']) ?></strong>
                    </a>
                    <div>
                        <span>Ngôn ngữ: <?= htmlspecialchars($c['language']) ?></span> |
                        <span>Giá: <?= number_format($c['price']) ?> VND</span> |
                        <span>Cập nhật: <?= $c['updated_at'] ?></span>
                    </div>
                    <div class="course-actions">
                        <a href="index.php?mod=course&act=edit&id=<?= $c['course_id'] ?>">✏️ Sửa</a> |
                        <a href="index.php?mod=course&act=delete&id=<?= $c['course_id'] ?>"
                            onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')">🗑️ Xóa</a> |
                        <a href="index.php?mod=course&act=lessonList&course_id=<?= $c['course_id'] ?>">📖 Quản lý bài học</a>

                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Bạn chưa tạo khóa học nào.</p>
    <?php endif; ?>

    <a class="btn-logout" href="index.php?mod=user&act=logout">Đăng xuất</a>
</div>

<style>
    /* ===== Container chính ===== */
    .profile-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 30px;
        background: #f9fafb;
        border-radius: 12px;
        font-family: 'Segoe UI', Arial, sans-serif;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* ===== Tiêu đề ===== */
    .profile-container h2 {
        margin-bottom: 20px;
        font-size: 22px;
        font-weight: 600;
        color: #1e3a8a;
        border-left: 5px solid #2563eb;
        padding-left: 10px;
    }

    .profile-container h3 {
        margin: 25px 0 15px;
        font-size: 20px;
        font-weight: 600;
        color: #0f172a;
    }

    /* ===== Thông báo ===== */
    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert.success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* ===== Thông tin user ===== */
    #profile-info p {
        margin: 6px 0;
        font-size: 15px;
        color: #374151;
    }

    #profile-info strong {
        color: #111827;
    }

    .avatar-box {
        margin: 15px 0;
    }

    .avatar-box img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #2563eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Trạng thái */
    .active {
        color: #16a34a;
        font-weight: bold;
    }

    .pending {
        color: #f59e0b;
        font-weight: bold;
    }

    /* ===== Form chỉnh sửa ===== */
    .update-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .update-form label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 3px;
    }

    .update-form input {
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .update-form input:focus {
        border-color: #2563eb;
        outline: none;
        box-shadow: 0 0 0 2px #93c5fd;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 15px;
    }

    .update-form button {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        font-weight: 600;
    }

    .update-form button[type="submit"] {
        background: #2563eb;
        color: #fff;
    }

    .update-form .cancel {
        background: #e5e7eb;
        color: #374151;
    }

    .update-form button:hover {
        opacity: 0.9;
    }

    /* ===== Danh sách khoá học ===== */
    .course-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .course-list li {
        background: #fff;
        padding: 15px 18px;
        margin-bottom: 12px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .course-list li:hover {
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
    }

    .course-list li a {
        font-size: 16px;
        font-weight: 600;
        color: #1d4ed8;
        text-decoration: none;
    }

    .course-list li a:hover {
        text-decoration: underline;
    }

    .course-actions {
        margin-top: 8px;
        font-size: 14px;
    }

    .course-actions a {
        margin-right: 10px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }

    .course-actions a:hover {
        text-decoration: underline;
    }

    /* ===== Nút ===== */
    #edit-btn,
    .btn-add,
    .btn-logout {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }

    #edit-btn {
        background: #2563eb;
        color: #fff;
        border: none;
    }

    .btn-add {
        background: #16a34a;
        color: #fff;
    }

    .btn-logout {
        background: #dc2626;
        color: #fff;
    }

    #edit-btn:hover {
        background: #1d4ed8;
    }

    .btn-add:hover {
        background: #15803d;
    }

    .btn-logout:hover {
        background: #b91c1c;
    }
</style>

<script>
    document.getElementById('edit-btn').addEventListener('click', function() {
        document.getElementById('profile-info').style.display = 'none';
        document.getElementById('edit-form').style.display = 'block';
    });
    document.getElementById('cancel-btn').addEventListener('click', function() {
        document.getElementById('edit-form').style.display = 'none';
        document.getElementById('profile-info').style.display = 'block';
    });
</script>
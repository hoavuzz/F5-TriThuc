<div class="profile-container">
    <h2>👤 Thông tin cá nhân</h2>

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

        <?php if ($user['role'] === 'teacher' && !empty($user['teacher_file'])): ?>
            <p><strong>File chứng minh:</strong>
                <a href="../uploads/teachers/<?= $user['teacher_file'] ?>" target="_blank">Xem file</a>
            </p>
        <?php endif; ?>

        <button id="edit-btn">✏️ Chỉnh sửa thông tin</button>
    </div>

    <!-- Form chỉnh sửa (ẩn mặc định) -->
    <form method="POST" id="edit-form" class="update-form" style="display:none;">
        <label>Tên</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Số điện thoại</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

        <div class="form-actions">
            <button type="submit">💾 Lưu thay đổi</button>
            <button type="button" id="cancel-btn" class="cancel">Hủy</button>
        </div>
    </form>

    <hr>

    <h3>📚 Khóa học đã mua</h3>
    <?php if (!empty($courses)): ?>
        <ul class="course-list">
            <?php foreach ($courses as $c): ?>
                <li>
                    <a href="index.php?mod=course&act=detail&id=<?= $c['course_id'] ?>">
                        <strong><?= htmlspecialchars($c['name']) ?></strong>
                    </a>
                    <div>
                        <span>Ngôn ngữ: <?= htmlspecialchars($c['language']) ?></span> |
                        <span>Giá: <?= number_format($c['price']) ?> VND</span> |
                        <span>Cập nhật: <?= $c['updated_at'] ?></span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Bạn chưa mua khóa học nào.</p>
    <?php endif; ?>

    <a class="btn-logout" href="index.php?mod=user&act=logout">Đăng xuất</a>
</div>

<style>
    .profile-container {
        max-width: 750px;
        margin: 20px auto;
        padding: 25px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }

    .profile-container h2 {
        margin-bottom: 15px;
        color: #6d28d9;
        border-bottom: 2px solid #eee;
        padding-bottom: 8px;
    }

    .user-info p {
        margin: 6px 0;
    }

    .avatar-box {
        margin: 15px 0;
    }

    .avatar-box img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #6d28d9;
    }

    .active {
        color: green;
        font-weight: bold;
    }

    .pending {
        color: orange;
        font-weight: bold;
    }

    .course-list {
        list-style: none;
        padding: 0;
    }

    .course-list li {
        background: #f9f9f9;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .course-list li a {
        color: #6d28d9;
        text-decoration: none;
        font-size: 16px;
    }

    .course-list li a:hover {
        text-decoration: underline;
    }

    .btn-logout {
        display: inline-block;
        margin-top: 20px;
        color: #fff;
        background: #6d28d9;
        padding: 10px 18px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }

    .btn-logout:hover {
        background: #4c1d95;
    }

    #edit-btn {
        margin-top: 15px;
        background: #6d28d9;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }

    #edit-btn:hover {
        background: #4c1d95;
    }

    .update-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 15px;
    }

    .update-form label {
        font-weight: bold;
        margin-top: 5px;
    }

    .update-form input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .update-form button {
        background: #6d28d9;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .update-form .cancel {
        background: #ccc;
        color: #333;
    }

    .update-form button:hover {
        opacity: 0.9;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .alert.success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert.error {
        background: #fee2e2;
        color: #991b1b;
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
<style>
    /* ===== MAIN CONTENT ===== */
    main {
        padding: 30px;
        background: #ecf0f1;
        min-height: 100vh;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ===== TABLE STYLING ===== */
    table {
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    table th {
        background: #34495e;
        color: #ecf0f1;
        padding: 16px;
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        letter-spacing: 0.5px;
    }

    table td {
        padding: 14px 10px;
        text-align: center;
        font-size: 14px;
        color: #2c3e50;
        border-bottom: 1px solid transparent; /* Không hiện viền */
    }

    table tr:not(:last-child) {
        border-bottom: 1px solid #f1f1f1; /* Rất nhẹ để phân cách dòng */
    }

    table tr:hover {
        background: #f8f9fa;
    }

    table input[type="text"],
    table input[type="email"],
    table select {
        width: 95%;
        padding: 8px 10px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        background: #f4f6f8;
        transition: 0.3s;
        outline: none;
    }

    table input:focus,
    table select:focus {
        background: #ffffff;
        box-shadow: 0 0 6px rgba(46, 204, 113, 0.3);
    }

    table img {
        border-radius: 6px;
        max-height: 60px;
    }

    table td button,
    table td a {
        padding: 7px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s ease;
        cursor: pointer;
    }

    table td button {
        border: none;
        background: #2ecc71;
        color: white;
        margin-right: 6px;
    }

    table td button:hover {
        background: #27ae60;
    }

    table td a {
        background: #e74c3c;
        color: white;
    }

    table td a:hover {
        background: #c0392b;
    }

    @media (max-width: 768px) {
        table {
            width: 100%;
        }

        table th,
        table td {
            font-size: 13px;
            padding: 10px 6px;
        }

        table input,
        table select {
            font-size: 12px;
        }
    }
</style>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Tên đăng nhập</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Role</th>
        <th>Trạng thái</th>
        <th>Chứng minh Giảng viên</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <form method="post">
                <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">
                <input type="hidden" name="update_user" value="1">

                <!-- ID -->
                <td><?= $u['user_id'] ?></td>

                <!-- Username -->
                <td>
                    <input type="text" name="username" value="<?= htmlspecialchars($u['username'] ?? '') ?>">
                </td>

                <!-- Email -->
                <td>
                    <input type="email" name="email" value="<?= htmlspecialchars($u['email'] ?? '') ?>">
                </td>

                <!-- Phone -->
                <td>
                    <input type="text" name="phone" value="<?= htmlspecialchars($u['phone'] ?? '') ?>">
                </td>

                <!-- Role -->
                <td>
                    <select name="role">
                        <option value="student" <?= ($u['role'] ?? '') == 'student' ? 'selected' : '' ?>>Student</option>
                        <option value="teacher" <?= ($u['role'] ?? '') == 'teacher' ? 'selected' : '' ?>>Teacher</option>
                    </select>
                </td>

                <!-- Status -->
                <td>
                    <select name="status">
                        <option value="1" <?= ($u['status'] ?? '') == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= ($u['status'] ?? '') == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </td>

                <!-- File Teacher (chỉ hiển thị) -->
                <td>
                    <?php if (($u['role'] ?? '') == 'teacher'): ?>
                        <?php if (!empty($u['teacher_file'])): ?>
                            <?php
                            $ext = pathinfo($u['teacher_file'], PATHINFO_EXTENSION);
                            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): ?>
                                <img src="../uploads/<?= $u['teacher_file'] ?>" width="80">
                            <?php else: ?>
                                <a href="../uploads/<?= $u['teacher_file'] ?>" target="_blank">Xem file</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <i>Chưa có file</i>
                        <?php endif; ?>
                    <?php else: ?>
                        <i>Không áp dụng</i>
                    <?php endif; ?>
                </td>

                <!-- Action -->
                <td>
                    <button type="submit">Lưu</button>
                    <a href="index.php?mod=user&act=delete&id=<?= $u['user_id'] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')">Xóa</a>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>
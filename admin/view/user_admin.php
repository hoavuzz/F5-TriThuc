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
                                if (in_array(strtolower($ext), ['jpg','jpeg','png'])): ?>
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

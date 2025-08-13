<div class="lesson-container">
    <h2>📚 Danh sách bài học - Khóa: <?= htmlspecialchars($course['name']) ?></h2>

    <?php if (!empty($success)): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>

    <div class="actions">
        <a href="index.php?mod=lesson&act=add&course_id=<?= $course['course_id'] ?>" class="btn-add">➕ Thêm bài học</a>
        <a href="index.php?mod=user&act=profileTeacher" class="btn-back">⬅ Quay lại khóa học</a>
    </div>

    <?php if (!empty($lessons)): ?>
        <table class="lesson-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên bài học</th>
                    <th>Mô tả</th>
                    <th>Cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $i => $l): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($l['title']) ?></td>
                        <td>
                            <?= !empty($l['description'])
                                ? htmlspecialchars(substr($l['description'], 0, 100)) . '...'
                                : '<em>Chưa có mô tả</em>' ?>
                        </td>
                        <td><?= $l['updated_at'] ?></td>
                        <td>
                            <a href="index.php?mod=lesson&act=edit&id=<?= $l['lesson_id'] ?>">✏️ Sửa</a> |
                            <a href="index.php?mod=lesson&act=delete&id=<?= $l['lesson_id'] ?>&course_id=<?= $course['course_id'] ?>"
                                onclick="return confirm('Bạn có chắc muốn xóa bài học này?')">🗑️ Xóa</a> |
                         <a href="index.php?mod=course&act=quiz&lesson_id=<?= $l['lesson_id'] ?>&course_id=<?= $course['course_id'] ?>">📑 Quản lý bài tập</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>⚠️ Khóa học này chưa có bài học nào.</p>
    <?php endif; ?>
</div>

<style>
    .lesson-container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    .lesson-container h2 {
        margin-bottom: 15px;
        color: #2563eb;
    }

    .actions {
        margin-bottom: 15px;
    }

    .actions .btn-add,
    .actions .btn-back {
        display: inline-block;
        padding: 8px 14px;
        background: #2563eb;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        margin-right: 8px;
    }

    .actions .btn-back {
        background: #6b7280;
    }

    .actions a:hover {
        opacity: 0.9;
    }

    .lesson-table {
        width: 100%;
        border-collapse: collapse;
    }

    .lesson-table th,
    .lesson-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .lesson-table th {
        background: #f3f4f6;
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
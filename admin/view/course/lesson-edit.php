<div class="main">
  <h2 class="form-title">Sửa Bài Học</h2>
  <form method="POST" class="form-lesson">
    <div class="form-group">
      <label for="course_id">Khóa học:</label>
      <select name="course_id" id="course_id" required>
        <?php foreach ($courses as $c): ?>
          <option value="<?= $c['course_id'] ?>" <?= $lesson['course_id'] == $c['course_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="title">Tiêu đề bài học:</label>
      <input type="text" name="title" id="title" value="<?= htmlspecialchars($lesson['title']) ?>" required>
    </div>

    <div class="form-group">
      <label for="status">Trạng thái:</label>
      <select name="status" id="status" required>
        <option value="1" <?= $lesson['status'] == 1 ? 'selected' : '' ?>>Kích hoạt</option>
        <option value="0" <?= $lesson['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
      </select>
    </div>

    <div class="form-actions">
      <button type="submit">Cập nhật</button>
      <a href="index.php?mod=lesson&act=list">Hủy</a>
    </div>
  </form>
</div>
<style>
    .main h2.form-title {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 20px;
  color: #333;
  text-align: center;
}

.form-lesson {
  background: #fff;
  padding: 24px;
  border-radius: 10px;
  max-width: 600px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  margin: 0 auto;
}

.form-group {
  margin-bottom: 18px;
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  font-weight: 500;
  color: #444;
}

.form-group input[type="text"],
.form-group select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  background-color: #fff;
}

.form-actions {
  margin-top: 20px;
  text-align: right;
}

.form-actions button {
  padding: 10px 16px;
  background-color: #f97316;
  color: #fff;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  margin-right: 10px;
}

.form-actions a {
  padding: 10px 16px;
  background-color: #e5e7eb;
  color: #333;
  text-decoration: none;
  border-radius: 6px;
  font-weight: 500;
  transition: background-color 0.2s ease;
}

.form-actions a:hover {
  background-color: #d1d5db;
}

</style>
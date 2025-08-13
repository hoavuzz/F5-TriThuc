<div class="main">
  <h2 class="form-title">Sửa Khóa Học</h2>
  <form method="POST" enctype="multipart/form-data" class="form-lesson">
    <div class="form-group">
      <label for="teacher_id">Teacher ID:</label>
      <input type="number" name="teacher_id" id="teacher_id" value="<?= $course['teacher_id'] ?>" required>
    </div>

    <div class="form-group">
      <select name="category_id" id="category_id" required>
  <?php foreach ($categories as $c): ?>
    <option value="<?= $c['category_id'] ?>" <?= $c['category_id'] == $course['category_id'] ? 'selected' : '' ?>>
      <?= htmlspecialchars($c['name']) ?>
    </option>
  <?php endforeach; ?>
</select>
    </div>

    <div class="form-group">
      <label for="name">Tên khóa học:</label>
      <input type="text" name="name" id="name" value="<?= htmlspecialchars($course['name']) ?>" required>
    </div>

    <div class="form-group">
      <label for="price">Giá (VNĐ):</label>
      <input type="number" name="price" id="price" value="<?= $course['price'] ?>" min="0" required>
    </div>

    <div class="form-group">
      <label>Ảnh hiện tại:</label><br>
      <?php if (!empty($course['image'])): ?>
        <img src="../uploads/courses/<?= $course['image'] ?>" width="120" style="margin-bottom: 10px;"><br>
      <?php endif; ?>
      <input type="file" name="image" id="image" accept="image/*">
    </div>

    <div class="form-group">
      <label for="description">Mô tả:</label>
      <textarea name="description" id="description" rows="5"><?= htmlspecialchars($course['description']) ?></textarea>
    </div>

    <div class="form-group">
      <label for="views">Lượt xem:</label>
      <input type="number" name="views" id="views" value="<?= $course['views'] ?>" min="0">
    </div>

    <div class="form-group">
      <label for="language">Ngôn ngữ:</label>
      <input type="text" name="language" id="language" value="<?= htmlspecialchars($course['language']) ?>" required>
    </div>

    <div class="form-actions">
      <button type="submit">Cập nhật</button>
      <a href="index.php?mod=course&act=list">Hủy</a>
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
  max-width: 700px;
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
.form-group input[type="number"],
.form-group input[type="file"],
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  background-color: #fff;
}

.form-group textarea {
  resize: vertical;
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
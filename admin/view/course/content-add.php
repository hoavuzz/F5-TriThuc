<div class="main">
  <h2 class="form-title">Thêm Nội Dung</h2>
  <form method="POST" class="form-lesson">
    <div class="form-group">
      <label for="lesson_id">Bài học:</label>
      <select name="lesson_id" id="lesson_id" required>
        <?php foreach ($lessons as $l): ?>
          <option value="<?= $l['lesson_id'] ?>"><?= htmlspecialchars($l['title']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="title">Nội dung:</label>
      <input type="text" name="title" id="title" required>
    </div>

    <!-- <div class="form-group">
      <label for="content">Nội dung chi tiết:</label>
      <textarea name="content" id="content" rows="5" required></textarea>
    </div> -->

    <div class="form-group">
      <label for="video_link">Video link:</label>
      <input type="text" name="video_link" id="video_link" placeholder="https://..." required>
    </div>

    <div class="form-group">
      <label for="content_type">Loại nội dung:</label>
      <select name="content_type" id="content_type" required>
        <option value="video">Video</option>
        <option value="text">Văn bản</option>
        <option value="quiz">Quiz</option>
      </select>
    </div>

    <div class="form-group">
      <label for="duration">Khoảng thời gian (giây):</label>
      <input type="number" name="duration" id="duration" min="0" placeholder="Nhập số giây">
    </div>

    <div class="form-group">
      <label for="status">Trạng thái:</label>
      <select name="status" id="status" required>
        <option value="1">Kích hoạt</option>
        <option value="0">Ẩn</option>
      </select>
    </div>

    <div class="form-actions">
      <button type="submit">Lưu</button>
      <a href="index.php?mod=content&act=list">Hủy</a>
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
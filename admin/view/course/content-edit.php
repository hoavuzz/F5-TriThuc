<div class="main">
  <h2 class="form-title">Sửa Nội Dung</h2>
  <form method="POST" class="form-lesson">
    <div class="form-group">
      <label for="lesson_id">Bài học:</label>
      <select name="lesson_id" id="lesson_id" required>
        <?php foreach ($lessons as $l): ?>
          <option value="<?= $l['lesson_id'] ?>" <?= $contentItem['lesson_id'] == $l['lesson_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($l['title']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="content">Nội dung chi tiết:</label>
      <textarea name="content" id="content" rows="5" required><?= htmlspecialchars($contentItem['content']) ?></textarea>
    </div>

    <div class="form-group">
      <label for="video_link">Video link:</label>
      <input type="text" name="video_link" id="video_link" value="<?= htmlspecialchars($contentItem['video_link']) ?>" placeholder="https://...">
    </div>

    <div class="form-group">
      <label for="content_type">Loại nội dung:</label>
      <select name="content_type" id="content_type" required>
        <option value="video" <?= $contentItem['content_type'] == 'video' ? 'selected' : '' ?>>Video</option>
        <option value="text" <?= $contentItem['content_type'] == 'text' ? 'selected' : '' ?>>Văn bản</option>
        <option value="quiz" <?= $contentItem['content_type'] == 'quiz' ? 'selected' : '' ?>>Quiz</option>
      </select>
    </div>

    <div class="form-group">
      <label for="duration">Khoảng thời gian (giây):</label>
      <input type="number" name="duration" id="duration" min="0" value="<?= htmlspecialchars($contentItem['duration']) ?>">
    </div>

    <div class="form-actions">
      <button type="submit">Cập nhật</button>
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

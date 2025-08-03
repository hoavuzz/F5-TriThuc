
<h2>Thêm Khóa Học</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Teacher ID: </label>
    <input type="number" name="teacher_id"><br><br>

    <label>Category ID: </label>
    <input type="number" name="category_id"><br><br>

    <label>Tên khóa học: </label>
    <input type="text" name="name" required><br><br>

    <label>Giá: </label>
    <input type="number" name="price" step="0.01"><br><br>

    <label>Ảnh: </label>
    <input type="file" name="image"><br><br>

    <label>Mô tả: </label>
    <textarea name="description"></textarea><br><br>

    <label>Ngôn ngữ: </label>
    <input type="text" name="language"><br><br>

    <button type="submit">Lưu</button>
    <a href="index.php?mod=course&act=list">Hủy</a>
</form>
<h2>Sửa Khóa Học</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Teacher ID: </label>
    <input type="number" name="teacher_id" value="<?= $course['teacher_id'] ?>"><br><br>

    <label>Category ID: </label>
    <input type="number" name="category_id" value="<?= $course['category_id'] ?>"><br><br>

    <label>Tên khóa học: </label>
    <input type="text" name="name" value="<?= htmlspecialchars($course['name']) ?>" required><br><br>

    <label>Giá: </label>
    <input type="number" name="price" step="0.01" value="<?= $course['price'] ?>"><br><br>

    <label>Ảnh: </label>
    <?php if ($course['image']): ?>
        <img src="/F5-TRITHUC/uploads/courses/<?= $course['image'] ?>" width="100"><br>
    <?php endif; ?>
    <input type="file" name="image"><br><br>

    <label>Mô tả: </label>
    <textarea name="description"><?= htmlspecialchars($course['description']) ?></textarea><br><br>

    <label>Ngôn ngữ: </label>
    <input type="text" name="language" value="<?= $course['language'] ?>"><br><br>

    <button type="submit">Cập nhật</button>
    <a href="index.php?mod=course&act=list">Hủy</a>
</form>

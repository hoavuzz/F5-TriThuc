<body>
    <div class="course-page-container">
        <aside class="filter-panel">
            <h3>Bộ lọc</h3>

            <form method="GET" action="index.php">
                <input type="hidden" name="mod" value="course">
                <input type="hidden" name="act" value="filter">

                <!-- Danh mục -->
                <div class="filter-group">
                    <p>Danh mục</p>
                    <?php foreach ($categories as $cat): ?>
                        <label>
                            <input type="radio" name="category_id" value="<?= $cat['category_id'] ?>">
                            <?= htmlspecialchars($cat['name'] ?? '') ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Mức giá -->
                <div class="filter-group">
                    <p>Mức giá</p>
                    <label><input type="radio" name="price" value="free"> Miễn phí</label>
                    <label><input type="radio" name="price" value="under500"> Dưới 500k</label>
                    <label><input type="radio" name="price" value="500-1000"> 500k - 1tr</label>
                    <label><input type="radio" name="price" value="over1000"> Trên 1tr</label>
                </div>

                <!-- Vì DB không có level/time nên bỏ phần này hoặc thêm cột trong DB -->
                <!--
            <div class="filter-group">
                <p>Trình độ</p>
                <label><input type="checkbox" name="level[]" value="Người mới bắt đầu"> Người mới bắt đầu</label>
                <label><input type="checkbox" name="level[]" value="Trung cấp"> Trung cấp</label>
                <label><input type="checkbox" name="level[]" value="Nâng cao"> Nâng cao</label>
            </div>
            <div class="filter-group">
                <p>Thời lượng</p>
                <label><input type="checkbox" name="duration[]" value="under5"> Dưới 5 giờ</label>
                <label><input type="checkbox" name="duration[]" value="5-20"> 5-20 giờ</label>
                <label><input type="checkbox" name="duration[]" value="over20"> Trên 20 giờ</label>
            </div>
            -->

                <button type="submit" class="btn-apply-filter">Áp dụng bộ lọc</button>
            </form>
        </aside>

        <main class="course-listing">
            <h2>Kết quả lọc</h2>
            <div class="course-grid">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="course-card">
                            <div class="course-image">
                                <?php
                                $image = $course['image'];
                                if (!empty($image)) {
                                    // Nếu là URL hợp lệ thì dùng trực tiếp
                                    if (filter_var($image, FILTER_VALIDATE_URL)) {
                                        $imgSrc = $image;
                                    } else {
                                        // Nếu là file local thì lấy trong uploads
                                        $imgSrc = "../uploads/courses/" . $image;
                                    }
                                } else {
                                    // Nếu không có ảnh thì dùng ảnh mặc định
                                    $imgSrc = "../uploads/default-course.jpg";
                                }
                                ?>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Course Image">
                                <span class="course-tag hot">HOT</span>
                            </div>
                            <div class="info">
                                <h3>
                                    <a href="index.php?mod=course&act=detail&id=<?= $course['course_id'] ?>">
                                        <?= htmlspecialchars($course['name'] ?? 'Chưa có tên') ?>
                                    </a>
                                </h3>
                                <p class="price"><?= number_format($course['price'] ?? 0, 0, ',', '.') ?> đ</p>
                                <div class="meta">
                                    <span>👥 <?= number_format($course['views'] ?? 0) ?> học viên</span>
                                    <span>🌐 <?= htmlspecialchars($course['language'] ?? 'Không rõ') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có khóa học nào phù hợp.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
<style>
    .course-page-container {
        display: flex;
        max-width: 1350px;
        margin: 40px auto;
        gap: 30px;
    }

    .filter-panel {
        width: 250px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-panel h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .filter-group {
        margin-bottom: 20px;
    }

    .filter-group p {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .filter-group label {
        display: block;
        margin: 5px 0;
        font-size: 14px;
    }

    .btn-apply-filter {
        width: 100%;
        padding: 10px;
        background: orange;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .course-listing {
        flex: 1;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .sort-box select {
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .course-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .img-box {
        position: relative;
    }

    .img-box img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .hot-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #fdd835;
        color: #333;
        font-size: 12px;
        font-weight: bold;
        padding: 4px 6px;
        border-radius: 3px;
        line-height: 1.2;
        text-align: center;
    }

    .info {
        padding: 15px;
    }

    .info h3 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .info .price {
        color: #f26b38;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .meta {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #555;
    }

    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .pagination button {
        padding: 6px 12px;
        border: 1px solid #ccc;
        background: #fff;
        border-radius: 5px;
        cursor: pointer;
    }

    .pagination .active {
        background: #f26b38;
        color: #fff;
        border-color: #f26b38;
    }
</style>
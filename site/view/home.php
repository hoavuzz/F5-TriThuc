<!-- Khóa học được xem nhiều -->
<section class="highlighted-courses">
    <div class="highlighted-header">
        <div>
            <h2>Khóa Học Được Xem Nhiều</h2>
            <p>Top các khóa học được học viên quan tâm nhất!</p>
        </div>
        <a href="index.php?mod=course&act=list" class="see-all-btn">Xem Tất Cả</a>
    </div>

    <div class="course-list">
        <?php foreach ($mostViewedCourses as $course): ?>
            <div class="course-item">
                <div class="course-image">
                    <img src="../uploads/courses/<?= htmlspecialchars($course['image']) ?>" alt="">
                    <span class="course-tag hot">HOT</span>
                </div>
                <div class="course-info">
                    <h3>
                        <a href="index.php?mod=course&act=detail&id=<?= $course['course_id'] ?>">
                            <?= htmlspecialchars($course['name']) ?>
                        </a>
                    </h3>
                    <p class="course-price"><?= number_format($course['price'], 0, ',', '.') ?> đ</p>
                    <div class="course-meta">
                        <span>👥 <?= number_format($course['views']) ?> lượt xem</span>
                    </div>
                    <a href="index.php?mod=cart&act=add&id=<?= $course['course_id'] ?>" class="buy-btn">Mua Ngay</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Khóa học miễn phí -->
<section class="highlighted-courses">
    <div class="highlighted-header">
        <div>
            <h2>Khóa Học Miễn Phí</h2>
            <p>Học tập thoải mái với những khóa học miễn phí chất lượng cao!</p>
        </div>
        <a href="index.php?mod=course&act=list&price=free" class="see-all-btn">Xem Tất Cả</a>
    </div>

    <div class="course-list">
        <?php foreach ($freeCourses as $course): ?>
            <div class="course-item">
                <div class="course-image">
                    <img src="../uploads/courses/<?= htmlspecialchars($course['image']) ?>" alt="">
                    <span class="course-tag free">FREE</span>
                </div>
                <div class="course-info">
                    <h3>
                        <a href="index.php?mod=course&act=detail&id=<?= $course['course_id'] ?>">
                            <?= htmlspecialchars($course['name']) ?>
                        </a>
                    </h3>
                    <p class="course-price free-text">Miễn phí</p>
                    <div class="course-meta">
                        <span>👥 <?= number_format($course['views']) ?> lượt xem</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Tất cả khóa học -->
<section class="highlighted-courses">
    <div class="highlighted-header">
        <div>
            <h2>Tất cả khóa học</h2>
            <p>Nơi hội tụ tri thức, mở ra cơ hội phát triển toàn diện trong mọi lĩnh vực!</p>
        </div>
        <a href="index.php?mod=course&act=list" class="see-all-btn">Xem Tất Cả</a> 
    </div>

    <div class="course-list">
        <?php foreach ($courses as $course): ?>
            <div class="course-item">
                <div class="course-image">
                    <img src="../uploads/courses/<?= htmlspecialchars($course['image']) ?>" alt="">
                    <span class="course-tag">DEAL HOT<br>HÔM NAY</span>
                </div>
                <div class="course-info">
                    
                    <h3><a href="index.php?mod=course&act=detail&id=<?= $course['course_id'] ?>"></a></h3>
                    <h3><?= htmlspecialchars($course['name']) ?></h3>
                    
                    <p class="course-price"><?= number_format($course['price'], 2) ?> đ</p>
                    <div class="course-meta">
                    
                        <span>👥 <?= number_format($course['views']) ?> học viên</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<style>
.highlighted-courses {
    padding: 20px 15px;
    margin: auto;
    max-width: 1350px;
    margin-bottom: 50px;
}

/* Header */
.highlighted-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
.highlighted-header h2 {
    font-size: 26px;
    color: #222;
    margin-bottom: 5px;
}
.highlighted-header p {
    color: #555;
    font-size: 15px;
    margin-top: 4px;
}

/* Nút xem tất cả */
.see-all-btn {
    border: 1px solid #333;
    border-radius: 20px;
    padding: 8px 20px;
    text-decoration: none;
    font-size: 14px;
    color: #333;
    font-weight: 600;
    transition: 0.25s ease;
}
.see-all-btn:hover {
    background: #333;
    color: #fff;
}

/* Danh sách khóa học */
.course-list {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    
}

/* Thẻ khóa học */
.course-item {
    width: 100%;
    max-width: 300px; /* Kích thước card cố định */
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.course-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

/* Ảnh khóa học */
.course-image {
    position: relative;
}
.course-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    border-radius: 9px;
}

/* Tag */
.course-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    font-weight: bold;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 4px;
    text-align: center;
    line-height: 1.2;
}
.course-tag.hot {
    background: #ffc107;
    color: #000;
}
.course-tag.free {
    background: green;
    color: white;
}
.course-tag.deal {
    background: red;
    color: white;
}

/* Thông tin khóa học */
.course-info {
    padding: 10px 10px;
}
.course-info h3 {
    font-size: 18px;

}
.course-info h3 a {
    color: #222;
    text-decoration: none;
}
.course-info h3 a:hover {
    color: #007bff;
}

.course-price {
    font-size: 16px;
    color: #e74c3c;
    font-weight: bold;
    margin-bottom: 12px;
}
.course-price.free-text {
    color: green;
}

.course-meta {
    font-size: 13px;
    color: #777;
}

.buy-btn {
    display: inline-block;
    padding: 10px 20px;
    background: #ff5722;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.3s ease;
    margin-top: 10px;
}
.buy-btn:hover {
    background: #e64a19;
}
</style>
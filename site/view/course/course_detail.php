<body>
    <main class="course-detail">
        <!-- Cột trái -->
        <div class="left-column">
            <h1><?= htmlspecialchars($course['name']) ?></h1>
            <p class="desc"><?= htmlspecialchars($course['description']) ?></p>
            <div class="btn-strong"><strong>Khoa hoc ban chay</strong></div>
            <div class="content-khoa-hoc">
                <li>- Khóa học giúp bạn xây dựng nền tảng vững chắc về HTML, CSS và JavaScript từ con số 0. </li>
                <li>- Từng bước học cách tạo giao diện web hiện đại, responsive và thêm tương tác bằng JavaScript. </li>
                <li>- Phù hợp cho người mới bắt đầu và muốn trở thành Frontend Developer.</li>
            </div>
            <!-- Giảng viên -->
            <div class="instructor">
                <img src="teacher.jpg" alt="Nguyễn Văn A">
                <div>
                    <h4>Nguyễn Văn A</h4>
                    <p>Ngày đăng: <?= htmlspecialchars($course['updated_at']) ?></p>
                    <span class="rating">⭐ 4.8 | 👥 <?= number_format($course['views']) ?> học viên</span>
                </div>
            </div>


            <!-- Nội dung khóa học -->
            <h3 class="section-title">📚 Nội dung khóa học</h3>
            <div class="course-content">
                <?php foreach ($lessons as $index => $lesson): ?>
                    <div class="chapter">
                        <div class="chapter-header" onclick="toggleContent(this)">
                            Bài <?= $index + 1 ?>: <?= htmlspecialchars($lesson['title']) ?>
                            <span class="arrow">▼</span>
                        </div>
                        <div class="chapter-lessons">
                            <?php foreach ($contents as $content): ?>
                                <?php if ($content['lesson_id'] == $lesson['lesson_id']): ?>
                                    <a href="index.php?mod=course&act=lesson&course_id=<?= $course['course_id'] ?>&lesson_id=<?= $lesson['lesson_id'] ?>&content_id=<?= $content['content_id'] ?>">
                                        <?= htmlspecialchars($content['content']) ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            

            <!-- Lý do học -->
            <div class="why-learn">
                <div class="box">
                    <h4>Ai nên học khóa này?</h4>
                    <ul>
                        <li>Sinh viên CNTT năm 2 trở lên</li>
                        <li>Người chuyển ngành sang lập trình</li>
                        <li>Người muốn ứng tuyển vị trí Frontend / Backend</li>
                    </ul>
                </div>
                <div class="box">
                    <h4>Yêu cầu đầu vào</h4>
                    <ul>
                        <li>Có laptop, internet ổn định</li>
                        <li>Biết sử dụng máy tính cơ bản</li>
                        <li>Tư duy logic tốt</li>
                    </ul>
                </div>
                <div class="box">
                    <h4>Lợi ích sau khi học</h4>
                    <ul>
                        <li>Tự tay làm web frontend + backend</li>
                        <li>Có project đưa vào CV</li>
                        <li>Nhận chứng chỉ hoàn thành khóa học</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Cột phải -->
        <div class="right-column">
            <div class="video-preview">
                <div class="course-image"><img src="../uploads/courses/<?= htmlspecialchars($course['image'] ?? '') ?>" alt=""></div>
            </div>

            <div class="price-box">
                <p class="price">1.200.000₫</p>
                <button class="btn-primary"><a href="controller/OrderController.php?course_id=<?= $course['course_id'] ?>" class="btn-buy">Mua ngay</a></button>
                

                <a href="index.php?mod=cart&act=add&course_id=<?= $course['course_id'] ?>" class="btn-secondary">🛒 Thêm vào giỏ</a>

                <!-- <a href="index.php?mod=course&act=renderLesson&course_id=<?= $course['course_id'] ?>" class="btn-secondary">🛒 Hoc bai</a> -->
                <ul>
                    <li>Học thử miễn phí 1 chương</li>
                    <li>Hoàn tiền 7 ngày</li>
                    <li>Chứng chỉ sau khi học xong</li>
                </ul>
            </div>

            <div class="info-box">
                <h4>Thông tin khóa học</h4>
                <ul>
                    <li>Thời lượng: 8 tuần</li>
                    <li>Số bài học: <?= $lessonCount ?></li>
                    <li>Ngôn ngữ: <?= htmlspecialchars($course['language']) ?></li>
                </ul>
            </div>
        </div>
    </main>
</body>




<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 0;
        color: #333;
    }

    /* Ảnh khóa học */
    .course-image {
        position: relative;
    }

    .course-image img {
        width: 360px;
        height: 200px;
        object-fit: cover;
        display: block;
        border-radius: 9px;
    }

    .course-detail {
        display: flex;
        gap: 30px;
        max-width: 1350px;
        margin: auto;
        padding: 30px 20px;
    }

    .left-column {
        flex: 2.8;
    }

    .right-column {
        flex: 1;
    }

    .content-khoa-hoc {
        font-size: small;
        /* margin-top: 10px;
        margin-bottom: 10px; */
        padding: 10px 0;
    }

    .content-khoa-hoc li {
        margin: 10px 0;
        text-decoration: none;
        list-style: none;
        
    }

    .box h4{
        font-size: large;
    }
    .box li{
        font-size: smaller;
        margin: 10px; 
    }

    h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .desc {
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .btn-strong {
        background-color: #FF600F;
        color: white;
        padding: 6px 10px;
        border-radius: 5px;
        font-size: 13px;
        width: fit-content;
        margin-bottom: 20px;
    }

    .instructor {
        display: flex;
        gap: 15px;
        align-items: center;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .instructor img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    .section-title {
        margin: 30px 0 10px;
        font-size: 20px;
        font-weight: bold;
    }

    .course-content .chapter {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 12px;
        background: #fff;
        overflow: hidden;
        transition: 0.3s;
    }

    .chapter-header {
        padding: 15px 20px;
        background: #f9f9f9;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s;
    }

    .chapter-header:hover {
        background: #eee;
    }

    .chapter-header .arrow {
        font-size: 12px;
        color: #666;
        transition: transform 0.3s ease;
    }

    .chapter.active .arrow {
        transform: rotate(180deg);
    }

    .chapter-lessons {
        display: none;
        flex-direction: column;
        padding: 15px 20px;
        animation: fadeIn 0.3s ease-in-out;
    }

    .chapter.active .chapter-lessons {
        display: flex;
    }

    .chapter-lessons a {
        color: #34495e;
        padding: 8px 0;
        text-decoration: none;
        transition: color 0.2s;
    }

    .chapter-lessons a:hover {
        color: #FF600F;
        /* background: #FF600F; */
    }

    .why-learn {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 30px;
    }

    .why-learn .box {
        background: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .why-learn ul {
        list-style: none;
        padding-left: 0;
    }

    .why-learn li::before {
        content: "✔ ";
        color: green;
        margin-right: 6px;
    }

    /* Right column */
    .video-preview {
        background: black;
        border-radius: 8px;
        height: 200px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 16px;
        font-weight: bold;
    }

    .price-box,
    .info-box {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    .info-box h4{
        font-size: large;
    }

    .price {
        font-size: 22px;
        color: #FF600F;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .btn-buy{
        text-decoration: none;
        color: white;
    }

    .btn-primary,
    .btn-secondary {
        display: block;
        width: 100%;
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        font-size: 16px;
        margin-bottom: 10px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: #FF600F;
        color: white;
        border: none;
    }

    .btn-secondary {
        background: white;
        color: #FF600F;
        border: 1px solid #FF600F;
        width: 300px;
        height: a;
    }

    .btn-secondary:hover {
        background: #FF600F;
        color: white;
    }

    .info-box ul {
        list-style: none;
        padding-left: 0;
    }

    .info-box li {
        margin-bottom: 6px;
        
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 900px) {
        .course-detail {
            flex-direction: column;
            padding: 15px;
        }

        .why-learn {
            grid-template-columns: 1fr;
        }
    }
</style>
<script>
    function toggleContent(header) {
        const chapter = header.closest('.chapter');
        chapter.classList.toggle('active');
    }
</script>
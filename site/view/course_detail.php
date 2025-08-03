<body>
    <main class="course-detail">
        <!-- Cột trái -->
        <div class="left-column">
            <h1><?= htmlspecialchars($course['name']) ?></h1>
            <p class="desc">
                <?= htmlspecialchars($course['description']) ?>
            </p>



            <div class="instructor">
                <img src="teacher.jpg" alt="Nguyễn Văn A">
                <div>
                    <h4>Nguyễn Văn A</h4>
                    <p>Ngày đăng: <?= htmlspecialchars($course['updated_at'] ?? '') ?> </p>
                    <span class="rating">⭐ 4.8 | 👥 <?= number_format($course['views']) ?> học viên</span>
                </div>
            </div>

            <h3>Nội dung khóa học</h3>
            <div class="course-content">

                <div class="chapter" data-chapter>
                    <div class="chapter-header">
                        Chương 1: Giới thiệu về HTML, CSS, JavaScript
                    </div>
                    <div class="chapter-lessons">
                        <?php foreach ($lessons as $lesson): ?>
                            <a href="index.php?mod=course&act=viewLesson&id=<?= $lesson['lesson_id'] ?>" class="lesson-item">
                                <?= htmlspecialchars($lesson['title']) ?>

                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="chapter" data-chapter>
                    <div class="chapter-header">
                        Chương 2: Xây dựng giao diện bằng React
                    </div>
                    <div class="chapter-lessons">
                        <p>Bài 1: Giới thiệu React</p>
                        <p>Bài 2: Component & Props</p>
                    </div>
                </div>

                <div class="chapter" data-chapter>
                    <div class="chapter-header">
                        Chương 3: Backend với Node.js, Express
                    </div>
                    <div class="chapter-lessons">
                        <p>Bài 1: Cài đặt môi trường</p>
                        <p>Bài 2: Xây dựng API</p>
                    </div>
                </div>

                <div class="chapter" data-chapter>
                    <div class="chapter-header">
                        Chương 4: Kết nối CSDL MongoDB
                    </div>
                    <div class="chapter-lessons">
                        <p>Bài 1: Kết nối MongoDB</p>
                        <p>Bài 2: CRUD cơ bản</p>
                    </div>
                </div>

                <div class="chapter" data-chapter>
                    <div class="chapter-header">
                        Chương 5: Triển khai dự án lên Hosting
                    </div>
                    <div class="chapter-lessons">
                        <p>Bài 1: Triển khai Heroku</p>
                        <p>Bài 2: Cấu hình domain</p>
                    </div>
                </div>
            </div>

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
                        <li>Nắm vững kiến thức nền tảng để tự học</li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Cột phải -->
        <div class="right-column">
            <div class="video-preview">
                <div class="video-thumbnail">🎬 Xem giới thiệu khóa học</div>


            </div>

            <div class="price-box">
                <p class="price">1.200.000₫</p>
                <button class="btn-primary">Đăng ký ngay</button>
                <button class="btn-secondary">Thêm vào giỏ hàng</button>
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
                    <li>Số bài học: 45 bài</li>
                    <li>Cấp độ: <?= ($course['level']) ?></li>
                    <li>Ngôn ngữ: <?= ($course['language']) ?></li>
                </ul>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #fff5ef;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .course-detail {
        display: flex;
        gap: 30px;
        max-width: 1350px;
        margin: auto;
        padding: 20px;
    }

    .left-column {
        flex: 2;
    }

    .right-column {
        flex: 1;
    }

    /* ===== Tiêu đề & mô tả ===== */
    h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .desc {
        color: #555;
        line-height: 1.6;
    }

    /* ===== Danh sách không dấu ===== */
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* ===== Lợi ích & icon check ===== */
    ul.benefits li::before,
    .why-learn ul li::before,
    .price-box ul li::before {
        content: "✔";
        color: #28a745;
        margin-right: 8px;
    }

    /* ===== Giảng viên ===== */
    .instructor {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 20px 0;
        padding: 15px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .instructor img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    /* ===== Nội dung khóa học ===== */
    .course-content {
        margin-top: 20px;
    }

    .lesson-item {
        display: block;
        padding: 8px 0;
        color: #333;
        text-decoration: none;
    }

    .lesson-item:hover {
        text-decoration: underline;
        color: #ff6600;
    }


    .chapter {
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .chapter-header {
        padding: 15px;
        font-weight: bold;
        background: #f6f6f6;
        cursor: pointer;
        transition: background 0.2s;
    }

    .chapter-header:hover {
        background: #ececec;
    }

    .chapter-lessons {
        display: none;
        padding: 15px;
        border-top: 1px solid #ddd;
    }

    .chapter.open .chapter-lessons {
        display: block;
    }

    .locked {
        color: gray;
    }

    /* ===== 3 box Ai nên học - Yêu cầu - Lợi ích ===== */
    .why-learn {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .why-learn .box {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    /* ===== Video preview ===== */
    .video-preview {
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        width: 100%;
    }

    .video-preview iframe {
        display: block;
        width: 100%;
        height: 315px;
        border: none;
    }

    .video-thumbnail {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8));
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        height: 200px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .video-thumbnail:hover {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
    }

    /* ===== Box giá và nút ===== */
    .price-box {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .price {
        font-size: 24px;
        font-weight: bold;
        color: #ff6600;
    }

    .btn-primary {
        background: #ff6600;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 6px;
        width: 100%;
        margin-top: 10px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.2s;
    }

    .btn-primary:hover {
        background: #e65500;
    }

    .btn-secondary {
        background: #fff;
        color: #ff6600;
        border: 1px solid #ff6600;
        padding: 10px;
        border-radius: 6px;
        width: 100%;
        margin-top: 10px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: #ff6600;
        color: #fff;
    }

    /* ===== Thông tin khóa học ===== */
    .info-box {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .info-box ul li {
        margin-bottom: 5px;
    }
</style>

<script>
    document.querySelectorAll("[data-chapter] .chapter-header").forEach(header => {
        header.addEventListener("click", () => {
            header.parentElement.classList.toggle("open");
        });
    });
</script>
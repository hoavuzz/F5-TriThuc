<div class="container">
    <!-- Cột trái -->
    <div class="left">
        <!-- Video bài học -->
        <div class="course-video">
            <?php if (!empty($lesson['video_url'])): ?>
                <iframe src="<?= htmlspecialchars($lesson['video_url']) ?>"
                        title="<?= htmlspecialchars($lesson['name']) ?>" allowfullscreen></iframe>
            <?php else: ?>
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                        title="Video demo" allowfullscreen></iframe>
            <?php endif; ?>
        </div>

        <!-- Tiêu đề -->
        <h1 class="course-title">
            <?= htmlspecialchars($lesson['name'] ?? 'Chưa có tiêu đề') ?>
        </h1>

        <!-- Thống kê -->
        <div class="course-stats">
            <span>⭐ 4.7</span>
            <span>👥 <?= number_format($course['views'] ?? 0) ?> học viên</span>
            <span><?= htmlspecialchars($lesson['duration'] ?? '0 giờ') ?></span>
        </div>

        <p class="update">Cập nhật <?= htmlspecialchars($course['updated_at'] ?? '') ?></p>
        <p class="language">Ngôn ngữ: <?= htmlspecialchars($course['language'] ?? 'Không rõ') ?></p>

        <!-- Box gợi ý lịch học -->
        <div class="schedule-box">
            <p><strong>Schedule learning time</strong><br>
            Học một chút mỗi ngày sẽ giúp bạn đạt mục tiêu dễ hơn. Đặt lịch học để nhận nhắc nhở.</p>
            <button class="btn">Get started</button>
            <button class="btn-outline">Dismiss</button>
        </div>

        <!-- Thông tin thêm -->
        <div class="by-numbers">
            <div><strong>Bài giảng:</strong> <?= htmlspecialchars($lesson['name'] ?? 'Không rõ') ?></div>
            <div><strong>Thời lượng:</strong> <?= htmlspecialchars($lesson['duration'] ?? 'Chưa cập nhật') ?></div>
            <div><strong>Khóa học:</strong> <?= htmlspecialchars($course['name'] ?? 'Không rõ') ?></div>
            <div><strong>Ngôn ngữ:</strong> <?= htmlspecialchars($course['language'] ?? 'Không rõ') ?></div>
        </div>

        <!-- Chứng chỉ -->
        <div class="certificate">
            <p>Hoàn thành khóa học để nhận chứng chỉ Udemy</p>
            <button class="btn"> Certificate</button>
        </div>

        <!-- Mô tả -->
        <div class="schedule-box">
            <p><strong>Description</strong><br>
            <?= htmlspecialchars($lesson['description'] ?? 'Chưa có mô tả') ?>
            </p>
        </div>

        <!-- Nội dung bài học -->
        <div class="lesson-body">
            <?= $lesson['content'] ?? '' ?>
        </div>
    </div>

    <!-- Cột phải -->
    <div class="right">
        <?php foreach ($sections as $section): ?>
        <div class="section">
            <div class="section-header">
                <div>
                    <h3><?= htmlspecialchars($section['name']) ?></h3>
                    <span><?= $section['completed'] ?? 0 ?> / <?= $section['total_lessons'] ?? 0 ?> | <?= $section['time'] ?? '0 phút' ?></span>
                </div>
                <div class="toggle-icon">▶</div>
            </div>
            <ul class="lesson-list">
                <?php foreach ($section['lessons'] as $les): ?>
                    <li class="<?= ($les['lesson_id'] == $lesson['lesson_id']) ? 'active' : '' ?>">
                        <a href="index.php?mod=course&act=lesson&id=<?= $les['lesson_id'] ?>">
                            Bài <?= $les['order'] ?>: <?= htmlspecialchars($les['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f8f8f8;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        display: flex;
        gap: 20px;
        max-width: 1350px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* Cột trái */
    .left {
        flex: 2;
    }

    .course-video {
        background: #000;
        aspect-ratio: 16 / 9;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 15px;
    }
    .course-video iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .course-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .course-stats {
        margin: 10px 0;
        font-size: 14px;
    }
    .course-stats span {
        margin-right: 15px;
    }

    .update, .language {
        font-size: 14px;
        color: gray;
    }

    .schedule-box {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 6px;
        margin: 15px 0;
    }

    .btn {
        background: #6d28d9;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #6d28d9;
        color: #6d28d9;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 8px;
    }

    .by-numbers {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        margin: 15px 0;
        font-size: 14px;
    }

    .certificate {
        margin-top: 15px;
        background: #f5f5f5;
        padding: 10px;
        border-radius: 6px;
    }

    .lesson-body {
        margin: 20px 0;
        line-height: 1.6;
    }

    /* Cột phải */
    .right {
        flex: 1;
        background: #fafafa;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid #ddd;
        max-height: 80vh;
        overflow-y: auto;
    }

    .section {
        border-bottom: 1px solid #ddd;
    }

    .section-header {
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .section-header h3 {
        font-size: 14px;
        margin: 0;
        font-weight: bold;
    }

    .section-header span {
        font-size: 12px;
        color: #666;
    }

    .toggle-icon {
        font-size: 14px;
        color: #666;
        transition: transform 0.3s;
    }

    .lesson-list {
        display: none;
        padding: 0 0 10px 10px;
        font-size: 13px;
        color: #555;
    }

    .lesson-list li {
        list-style: none;
        margin-bottom: 4px;
    }

    .lesson-list li a {
        text-decoration: none;
        color: #333;
    }

    .lesson-list li.active a {
        color: #6d28d9;
        font-weight: bold;
    }

    .open .lesson-list {
        display: block;
    }
    .open .toggle-icon {
        transform: rotate(90deg);
    }

    /* Responsive */
    @media (max-width: 900px) {
        .container {
            flex-direction: column;
        }
        .right {
            max-height: none;
        }
    }
</style>

<script>
    document.querySelectorAll('.section-header').forEach(header => {
        header.addEventListener('click', () => {
            const section = header.parentElement;
            section.classList.toggle('open');
        });
    });
</script>

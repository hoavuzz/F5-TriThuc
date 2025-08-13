<div class="container">
    <!-- Cột trái -->
    <div class="left">
        <div class="course-video">
            <?php if (!empty($video_link)): ?>
                <iframe src="<?= htmlspecialchars($video_link) ?>" allowfullscreen></iframe>
            <?php else: ?>
                <p>Chưa có video cho bài học này.</p>
            <?php endif; ?>
        </div>

        <!-- Phần tiêu đề video -->
        <h1 class="course-title">
            <?= htmlspecialchars($currentContent['content'] ?? 'Chưa có tiêu đề') ?>

        </h1>

        <!-- Thống kê -->
        <div class="course-stats">
            <span>⭐ 4.7</span>
            <span>👥 <?= number_format($course['views'] ?? 0) ?> học viên</span>
            <span><?= htmlspecialchars($content['duration'] ?? '0 giờ') ?></span>
            <div class="btn-bt"><a href="index.php?mod=course&act=getQuiz&id=<?= $lesson['lesson_id'] ?>"><button>Làm Bài Tập</button></a></div>
        </div>

        <p class="update">Cập nhật <?= htmlspecialchars($course['updated_at'] ?? '') ?></p>
        <p class="language">Ngôn ngữ: <?= htmlspecialchars($course['language'] ?? 'Không rõ') ?></p>

        <!-- Box gợi ý lịch học -->
        <div class="schedule-box">
            <p><strong>Lên lịch thời gian học tập</strong><br><br>
                Học một chút mỗi ngày sẽ tích lũy thêm kiến thức. Nghiên cứu cho thấy những học sinh biến việc học thành thói quen có nhiều khả năng đạt được mục tiêu hơn. Hãy dành thời gian học tập và nhận lời nhắc nhở bằng cách sử dụng lịch học tập của bạn.
            </p>
            <button class="btn">Bắt đầu</button>
            <button class="btn-outline">Bỏ qua</button>
        </div>

        <!-- Chứng chỉ -->
        <div class="certificate">
            <p>Hoàn thành khóa học để nhận chứng chỉ </p>
            <button class="btn">Nhận chứng chỉ</button>
        </div>

        <!-- Mô tả -->
        <div class="schedule-box">
            <p><strong>Mô tả bài học</strong><br><br>
                <!-- <?= htmlspecialchars($lesson['description'] ?? 'Chưa có mô tả') ?> -->
                Công nghệ thông tin (CNTT) là lĩnh vực nghiên cứu và ứng dụng các hệ thống, phần mềm, và mạng máy tính để thu thập, xử lý, lưu trữ và truyền tải thông tin.
                Nó đóng vai trò quan trọng trong hầu hết các ngành nghề, từ giáo dục, y tế đến thương mại và giải trí.
                Nhờ sự phát triển của CNTT, việc kết nối và chia sẻ dữ liệu trở nên nhanh chóng, tiện lợi và hiệu quả hơn bao giờ hết.
            </p>

        </div>

        <!-- Nội dung bài học -->
        <div class="lesson-body">
            <?= $lesson['content'] ?? '' ?>
        </div>
    </div>

    <!-- Cột phải -->
    <div class="right">
        <!-- Nội dung khóa học -->
        <h3 class="section-title">📚 Nội dung khóa học</h3>
        <!-- Phần danh sách nội dung -->
        <?php foreach ($lessons as $index => $lessonItem): ?>
            <div class="chapter">
                <div class="chapter-header" onclick="toggleContent(this)">
                    Bài <?= $index + 1 ?>: <?= htmlspecialchars($lessonItem['title']) ?>
                    <span class="arrow"> </span>
                </div>
                <div class="chapter-lessons">
                    <?php foreach ($allContents as $content): ?>
                        <?php if ($content['lesson_id'] == $lessonItem['lesson_id']): ?>
                            <a href="index.php?mod=course&act=lesson&course_id=<?= $course['course_id'] ?>&lesson_id=<?= $lessonItem['lesson_id'] ?>&content_id=<?= $content['content_id'] ?>">
                                <?= htmlspecialchars($content['content']) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .left {
        flex: 2.3;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .course-stats {
        margin: 10px 0;
        font-size: 14px;
    }

    .course-stats .btn-bt a button {
        float: right;
        background-color: #FF6009;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .course-stats .btn-bt a button:hover {
        background: white;
        border: 1px solid #FF6009;
        color: #FF6009;
    }

    .course-stats span {
        margin-right: 15px;
    }

    .update,
    .language {
        font-size: 14px;
        color: gray;
    }

    .schedule-box {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 6px;
        margin: 15px 0;
    }

    .schedule-box p {
        margin-bottom: 20px;
    }

    .schedule-box p strong {
        /* color: #FF6009; */
        font-size: large;
        margin-bottom: 20px;
    }

    .btn {
        background: #FF6009;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #FF6009;
        color: #FF6009;
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

    .right {
        flex: 1;
        background: #fafafa;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid #ddd;
        max-height: 80vh;
        overflow-y: auto;
    }

    .course-content .chapter {
        margin-bottom: 10px;
    }

    .chapter-header {
        background: #e5e5e5;
        padding: 10px;
        cursor: pointer;
        font-weight: bold;
        border-radius: 4px;
        margin-top: 10px;
    }

    .chapter-lessons {
        display: none;
        padding: 10px;
        /* margin-top: 5px; */
        border-radius: 0px 0px 9px 9px;
        background: #fafafaff;
        height: auto;
    }


    .chapter-lessons a {
        display: block;
        padding: 4px 0;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }

    .chapter-lessons a:hover {
        color: #FF6009;
    }

    .chapter.open .chapter-lessons {
        display: block;
    }

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
    function toggleContent(el) {
        const chapter = el.closest('.chapter');
        chapter.classList.toggle('open');
    }
</script>
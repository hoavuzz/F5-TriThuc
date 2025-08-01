    <div class="quiz-container-two">
    <div class="activity-builder">
    <div class="sidebar">
        <h3>Bắt đầu từ</h3>
        <ul>
        <li><i class="fa-regular fa-table"></i> Nhập bảng tính</li>
        <li><i class="fa-solid fa-wand-magic-sparkles"></i> Tạo bằng AI</li>
        <li class="active"><i class="fa-solid fa-pencil"></i> Tạo từ đầu</li>
        </ul>
    </div>


    <!-- CHỌN KHÓA HỌC THEO ID CỦA NGƯỜI DÙNG (User | Teacher) -->
    <div class="question-types">
        <div class="search-section">
            <h3>THÔNG TIN QUIZ</h3>
            <form method="GET" action="">
                <label for="course-select">Chọn khóa học:</label>
                <select id="course-select" name="course_id" onchange="this.form.submit()">
                    <option value="">-- Chọn khóa học --</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['courses_id'] ?>"
                            <?= isset($_GET['course_id']) && $_GET['course_id'] == $course['courses_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['name_courses']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
            

            <!-- CHỌN BÀI HỌC THEO ID KHÓA HỌC -->
            <form method="GET" action="">
    <!-- Giữ course_id trong form để không mất khi submit -->
                <?php if (isset($_GET['course_id'])): ?>
                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($_GET['course_id']) ?>">
                <?php endif; ?>

                <label for="lesson-select">Chọn bài học:</label>
                <select id="lesson-select" name="lesson_id" onchange="this.form.submit()">
                    <option value="">-- Chọn bài học --</option>
                    <?php
                        if (isset($_GET['course_id']) && $_GET['course_id']) {
                            $courses_id = $_GET['course_id'];
                            $lessons = $quizmodel->getLessonsByCourseId($courses_id);
                            foreach ($lessons as $lesson):
                    ?>
                        <option value="<?= $lesson['lesson_id'] ?>"
                            <?= isset($_GET['lesson_id']) && $_GET['lesson_id'] == $lesson['lesson_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($lesson['title']) ?>
                        </option>
                    <?php
                            endforeach;
                        }
                    ?>
                </select>
            </form>



            <!-- PHƯƠNG THỨC TẠO QUIZ -->
        <div class="type-grid">
            <h4>Loại câu hỏi</h4>
            <div class="question-buttons">
                <a href="?<?= http_build_query(array_merge($_GET, ['meth' => 1])) ?>">
                    <button type="button" class="type-btn <?= (isset($_GET['meth']) && $_GET['meth'] == 1) ? 'selected' : '' ?>">
                        🔘 Nhiều lựa chọn
                    </button>
                </a>

                <a href="?<?= http_build_query(array_merge($_GET, ['meth' => 2])) ?>">
                    <button type="button" class="type-btn <?= (isset($_GET['meth']) && $_GET['meth'] == 2) ? 'selected' : '' ?>">
                        📄 Đoạn văn
                    </button>
                </a>
            </div>
        </div>



        <form method="GET" action="">
            <input type="hidden" name="page" value="quiz-upload-select"> <!-- Phải là quiz-upload-select -->
            <input type="hidden" name="course_id" value="<?= $_GET['course_id'] ?? '' ?>">
            <input type="hidden" name="lesson_id" value="<?= $_GET['lesson_id'] ?? '' ?>">
            <input type="hidden" name="meth" id="meth-value" value="<?= $_GET['meth'] ?? '' ?>">
            <input type="hidden" name="time" id="hidden-time" value="30">

            <div class="time-slider-container">
                <input type="range" id="time-range" min="15" max="120" value="30" step="5">
                <span id="time-display">30 phút</span>
            </div>

            <button type="submit" class="mode-btn active dieuhuong">Tiếp</button>
        </form>


        </div>

        <div class="preview">
            <video src="../public/video/video-huong-dan.mp4" autoplay muted playsinline loop></video>
                <p>
                    Đánh giá sự hiểu biết của học sinh về một đoạn văn hoặc phương tiện nhất định. 
                    Với loại câu hỏi này, bạn có thể tạo các bài tập đọc tương tác yêu cầu người tham gia xem 
                    đoạn văn hoặc phương tiện và trả lời câu hỏi dựa trên sự hiểu biết của họ.
                </p>
        </div>
    </div>
    </div>
    </div>
    <script src="../public/js/quiz-scrip.js"></script>

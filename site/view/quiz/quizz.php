
    <link rel="stylesheet" href="../public/css/quiz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="quiz-container">
        <div class="sidebar">
            <h3>Bắt đầu từ</h3>
            <ul>
            <li><i class="fa-solid fa-file"></i> Thêm Câu</li>
            <a class="bogach" href="index.php?mod=course&act=editquiz&lesson_id=<?= $lesson[0]['lesson_id'] ?>&course_id=<?= $course[0]['course_id'] ?>"><li><i class="fa-solid fa-wand-magic-sparkles"></i>Sửa</li></a>
            <li class="active"><i class="fa-solid fa-pencil"></i> Tạo Quiz</li>
            </ul>
        </div>

        <div class="main-content">
            <div class="section-header">Thông tin Quiz</div>
                    <label for="courses">Khóa học</label>
                    <select name="courses_id" id="courses" onchange="this.form.submit()">
                        <option value="<?= $course[0]['course_id'] ?>"><?= $course[0]['name'] ?></option>
                    </select>

                    <!-- Bài học -->
                    <label for="lessons">Bài học</label>
                    <select name="lesson_id" id="lessons" onchange="this.form.submit()">
                        <option value="<?= $lesson[0]['lesson_id'] ?>"><?= $lesson[0]['title'] ?></option>
                    </select>

            <!-- Chọn Loại câu hỏi -->
            <div class="section-header">Loại câu hỏi</div>
                <form method="GET" action="">
                    <?php
                        // Giữ lại các tham số đã có trên URL như course_id, lesson_id
                        foreach ($_GET as $key => $value) {
                            if ($key !== 'meth') {
                                echo "<input type='hidden' name='".htmlspecialchars($key)."' value='".htmlspecialchars($value)."'>";
                            }
                        }
                    ?>

                    <div class="button-group">
                        <button type="submit" name="meth" value="1" class="type-btn <?= (isset($_GET['meth']) && $_GET['meth'] == '1') ? 'active' : '' ?>">
                            <i class="fa-solid fa-check-double"></i> Nhiều lựa chọn
                        </button>

                        <button type="submit" name="meth" value="2" class="type-btn <?= (isset($_GET['meth']) && $_GET['meth'] == '2') ? 'active' : '' ?>">
                            <i class="fa-solid fa-file"></i> Đoạn văn
                        </button>
                    </div>
                </form>


            <div class="time-slider">
            <label>Thời gian làm bài: <span id="time-display">30 phút</span></label>
            <input type="range" min="15" max="120" value="30" step="5" id="time-range">
            </div>

            <form method="GET" action="index.php">
                <!-- Định tuyến -->
                <input type="hidden" name="mod" value="course"> <!-- hoặc quiz -->
                <input type="hidden" name="act" value="question">

                <!-- Quiz inputs -->
                <label for="quiz_title">Tiêu đề</label>
                <input type="text" name="quiz_title" id="quiz_title" placeholder="Nhập tiêu đề...">

                <label for="quiz_description">Mô tả</label>
                <input type="text" name="quiz_description" id="quiz_description" placeholder="Nhập mô tả...">

                <label for="total_score">Tổng điểm</label>
                <input type="text" name="total_score" id="total_score" placeholder="Nhập điểm...">

                <label for="pass_score">Điểm đậu</label>
                <input type="text" name="pass_score" id="pass_score" placeholder="Nhập điểm...">

                <!-- Các dữ liệu khác -->
                <input type="hidden" name="course_id" value="<?= $_GET['course_id'] ?? '' ?>">
                <input type="hidden" name="lesson_id" value="<?= $_GET['lesson_id'] ?? '' ?>">
                <input type="hidden" name="time" value="<?= $_GET['time'] ?? '' ?>">
                <input type="hidden" name="meth" value="<?= $_GET['meth'] ?? '' ?>">
                <br>
                <br>
                <!-- Nút submit -->
                <button type="submit" class="next-btn">Tiếp tục</button>
            </form>

        </div>
        </div>
        
<script>
    const range = document.getElementById("time-range");
    const display = document.getElementById("time-display");

    function updateURLParam(param, value) {
        const url = new URL(window.location.href);
        url.searchParams.set(param, value);
        window.location.href = url.toString(); // Reload trang với URL mới
    }

    // Hiển thị giá trị ban đầu
    display.textContent = range.value + " phút";

    // Nếu không có tham số time trong URL → thêm mặc định vào
    const currentURL = new URL(window.location.href);
    if (!currentURL.searchParams.has("time")) {
        updateURLParam("time", range.value);
    }

    // Cập nhật hiển thị khi kéo
    range.addEventListener("input", function () {
        display.textContent = this.value + " phút";
    });

    // Khi thả chuột (người dùng chọn xong), đẩy lên URL
    range.addEventListener("change", function () {
        updateURLParam("time", this.value);
    });
</script>

<style>
    label {
    display: block;
    margin-top: 16px;
    font-weight: bold;
    font-size: 14px;
    color: #333;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px 14px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #007BFF;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.4);
        outline: none;
    }

    .bogach{
        text-decoration: none;
        color: black;
    }

</style>

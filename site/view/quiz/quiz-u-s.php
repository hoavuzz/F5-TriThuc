<!-- File: admin/view/quiz-u-s.php -->
<link rel="stylesheet" href="../public/css/quiz.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="quiz-container">
    <div class="sidebar">
        <h3>Upload Quiz</h3>
        <ul>
            <li class="active"><i class="fa-solid fa-pencil"></i> Tạo thủ công</li>
        </ul>
    </div>

    <div class="main-content">
        <form method="POST" action="index.php?mod=course&act=question&lesson_id=<?= $lesson_id ?>&course_id=<?= $course_id ?>&quiz_title=<?= urlencode($title) ?>&quiz_description=<?= urlencode($description) ?>&total_score=<?= $total_score ?>&pass_score=<?= $pass_score ?>&time=<?= $time_limit ?>&meth=<?= $method ?>
" id="quiz-form">
            <div class="form-group">
                <label for="question">Câu hỏi:</label>
                <textarea name="question" id="question" required></textarea>
            </div>

            <div class="form-group">
                <label>Đáp án:</label>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="answer-row">
                        <input type="checkbox" name="correct[]" value="<?= $i ?>" id="correct-<?= $i ?>">
                        <input type="text" name="answer<?= $i ?>" placeholder="Đáp án <?= $i ?>" required>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="form-group">
                <label for="score">Điểm cho câu hỏi:</label>
                <input type="number" name="score" id="score" value="10" min="0" required>
            </div>

            <div class="button-group" style="margin-top: 20px;">
                <a href="index.php?mod=course&act=quiz&lesson_id=<?= $lesson_id ?>&course_id=<?= $course_id ?>" class="type-btn">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" name="action" value="add" class="type-btn active">
                    <i class="fa-solid fa-plus"></i> Thêm câu
                </button>
                <button type="submit" name="action" value="finish" class="type-btn">
                    <a href="index.php?mod=user&act=profileTeacher" class="type-btn">
                        <i class="fa-solid fa-check"></i> Xong
                    </a>
                </button>
            </div>
        </form>
    </div>
</div>

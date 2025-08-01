<form id="quizForm" method="POST">
  <div class="quiz-builder">

    <!-- Câu hỏi -->
    <div class="question-area">
      <label class="section-title">Câu hỏi</label>
      <textarea class="question-input" name="question" placeholder="Nhập câu hỏi vào đây..." required></textarea>
    </div>

    <!-- Điểm cho câu hỏi -->
    <div class="question-score">
      <label>Điểm cho câu hỏi này:</label>
      <input type="number" name="score" value="10" min="1" step="1" required>
    </div>

    <!-- Tùy chọn trả lời -->
    <div class="answers-area">
      <div class="answer-card blue">
        <textarea name="answers[]" placeholder="Nhập đáp án..." required></textarea>
        <input type="radio" name="correct_answer" value="0" required>
      </div>
      <div class="answer-card green">
        <textarea name="answers[]" placeholder="Nhập đáp án..." required></textarea>
        <input type="radio" name="correct_answer" value="1">
      </div>
      <div class="answer-card orange">
        <textarea name="answers[]" placeholder="Nhập đáp án..." required></textarea>
        <input type="radio" name="correct_answer" value="2">
      </div>
      <div class="answer-card red">
        <textarea name="answers[]" placeholder="Nhập đáp án..." required></textarea>
        <input type="radio" name="correct_answer" value="3">
      </div>
    </div>

    <!-- Nút điều hướng -->
    <div class="actions">
      <a href="?page=quiz">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Quay lại</button>
      </a>
      <button type="submit" name="action" value="add" class="add">Thêm câu</button>
      <button type="submit" name="action" value="done" class="done">Xong</button>
    </div>

  </div>

  <!-- Giữ tham số GET trong form -->
  <input type="hidden" name="course_id" value="<?= $_GET['course_id'] ?>">
  <input type="hidden" name="lesson_id" value="<?= $_GET['lesson_id'] ?>">
  <input type="hidden" name="meth" value="<?= $_GET['meth'] ?>">
  <input type="hidden" name="time" value="<?= $_GET['time'] ?>">
</form>

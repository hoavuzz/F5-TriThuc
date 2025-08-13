<div class="quiz-container">
    <div class="time" style="text-align: right;">
        Thời gian: <span id="time"></span>
    </div>

    <?php
    if (isset($question_data) && !empty($question_data)) {
        $question_number = 1;
        foreach ($question_data as $q_id => $data) {
            $question_text = $data['question_text'];
            $score = $data['score'];
            $question_type = $data['question_type'];
    ?>
    <div class="question" style="display: flex; justify-content: space-between; align-items: baseline;">
        Câu <?php echo $question_number; ?>: <?php echo htmlspecialchars($question_text); ?>
        <div class="score">
            Điểm: <span id="score-q<?php echo $q_id; ?>"><?php echo htmlspecialchars($score); ?></span>
        </div>
    </div>
    <div class="options">
        <?php
        if ($question_type === 'multiple') {
            $option_letters = ['A', 'B', 'C', 'D'];
            $option_index = 0;
            foreach ($data['options'] as $option) {
                $option_text = $option['option_text'];
                $is_correct = $option['is_correct'];
                $option_id = $option['option_id'];
        ?>
        <div class="option">
            <input type="radio" name="q<?php echo $q_id; ?>" value="<?php echo $option_id; ?>" <?php echo $is_correct ? 'data-correct' : ''; ?>>
            <?php echo $option_letters[$option_index]; ?>. <?php echo htmlspecialchars($option_text); ?>
        </div>
        <?php
                $option_index++;
            }
        } else {
        ?>
        <div class="option">
            <input type="text" name="q<?php echo $q_id; ?>" placeholder="Nhập câu trả lời">
        </div>
        <?php
        }
        ?>
    </div>
    <?php
        if ($question_number == count($question_data)) {
    ?>
        <a href="index.php?mod=course&act=submitQuiz&lesson_id=<?php echo $lesson_id; ?>"><button onclick="submitQuiz()">Nộp bài</button></a>
        <div id="result"></div>
    <?php
        }
        $question_number++;
        }
    } else {
        echo "Không có câu hỏi để hiển thị.";
    }
    ?>

    <script>
    let timeLeft = <?php echo $time_limit ?? 0; ?> * 60; // Chuyển sang giây
    let timer = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        document.getElementById('time').innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        if (--timeLeft < 0) {
            clearInterval(timer);
            console.log("Thời gian hết, gọi submitQuiz()");
            submitQuiz(); // Nộp bài tự động khi hết giờ
        }
    }, 1000);

    function submitQuiz() {
        clearInterval(timer); // Dừng đồng hồ khi nộp bài
        let totalScore = 0;
        let maxScore = 0;
        let answers = {};
        let questions = document.querySelectorAll('.question');

        questions.forEach((question, index) => {
            let qId = question.querySelector('.score span').id.replace('score-q', '');
            let scoreElement = document.getElementById(`score-q${qId}`);
            maxScore += parseFloat(scoreElement.textContent);

            let selectedOption = document.querySelector(`input[name="q${qId}"]:checked`);
            let textAnswer = document.querySelector(`input[name="q${qId}"]`);
            if (selectedOption) {
                answers[qId] = selectedOption.value;
                let correctOption = document.querySelector(`input[name="q${qId}"][data-correct]`);
                if (selectedOption && correctOption && selectedOption.value === correctOption.value) {
                    totalScore += parseFloat(scoreElement.textContent);
                    scoreElement.style.color = 'green';
                } else if (selectedOption) {
                    scoreElement.style.color = 'red';
                }
            } else if (textAnswer) {
                answers[qId] = textAnswer.value.trim();
            }
        });

        let resultDiv = document.getElementById('result');
        let isPassed = totalScore >= (maxScore * 0.5); // Giả sử pass score là 50%
        resultDiv.innerHTML = `Điểm của bạn: ${totalScore}/${maxScore}. ${isPassed ? 'Bạn đã vượt qua!' : 'Bạn chưa vượt qua.'}`;
        console.log("Điểm tính được:", totalScore, "Tổng điểm:", maxScore, "Trạng thái:", isPassed);

        // Gửi dữ liệu đến QuizController qua POST
        let userId = <?php echo json_encode($_SESSION['user']['user_id'] ?? null); ?>;
        let quizId = <?php echo json_encode($quizzes[0]['quiz_id'] ?? null); ?>;
        let duration = <?php echo $time_limit ?? 0; ?> * 60 - timeLeft;
        console.log("Dữ liệu gửi đi:", { userId, quizId, score: totalScore, max_score: maxScore, isPassed, duration, answers });

        fetch('index.php?mod=course&act=submitQuiz&lesson_id=<?php echo $lesson_id; ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=submit_quiz&user_id=${userId}&quiz_id=${quizId}&score=${totalScore}&max_score=${maxScore}&is_passed=${isPassed ? 1 : 0}&duration=${duration}&answers=${encodeURIComponent(JSON.stringify(answers))}`
        })
        .then(response => {
            console.log("Phản hồi từ server:", response);
            return response.json();
        })
        .then(data => {
            console.log("Dữ liệu trả về:", data);
            if (data.status === 'success') {
                console.log(data.message);
                resultDiv.innerHTML += `<br>${data.message}`;
            } else {
                console.error(data.message);
                resultDiv.innerHTML += `<br>Lỗi: ${data.message}`;
            }
        })
        .catch(error => {
            console.error('Lỗi fetch:', error);
            resultDiv.innerHTML += `<br>Lỗi kết nối server.`;
        });
    }
</script>
</div>

<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 20px;
    line-height: 1.5;
}

.quiz-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.time {
    position: absolute;
    top: 120px;
    right: 20%;
    font-size: 14px;
    color: #34495e;
    font-weight: 500;
}

.question {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ecf0f1;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 5px; /* Khoảng cách rất nhỏ giữa câu hỏi và điểm */
}

.score {
    font-size: 14px;
    color: #7f8c8d;
    font-weight: 500;
    margin-left: 0;
}

.options {
    margin-bottom: 20px;
}

.option {
    margin: 10px 0;
    display: flex;
    align-items: center;
}

input[type="radio"] {
    margin-right: 10px;
    accent-color: #a13abe;
    transform: scale(1.1);
    cursor: pointer;
}

button {
    background: linear-gradient(90deg, #ff6f61, #a13abe);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    display: block;
    margin: 20px auto 0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(161, 58, 190, 0.3);
}

button:hover {
    background: linear-gradient(90deg, #e65b53, #8f2ab5);
    box-shadow: 0 3px 8px rgba(161, 58, 190, 0.4);
}

#result {
    margin-top: 20px;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    text-align: center;
    padding: 10px;
    background-color: #f1f6fa;
    border-radius: 6px;
    display: none;
}
</style>
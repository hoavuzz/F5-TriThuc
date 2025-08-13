<link rel="stylesheet" href="../public/css/quiz.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="quiz-container">
    <div class="sidebar">
        <h3>Edit Quiz</h3>
        <ul>
            <li class="active"><i class="fa-solid fa-wand-magic-sparkles"></i>Sửa</li>
        </ul>
    </div>

    <div class="main-content">
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center;">Question ID</th>
                    <th style="text-align: center;">Question Text</th>
                    <th style="text-align: center;">Question Type</th>
                    <th style="text-align: center;">Score</th>
                    <th style="text-align: center;">Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $q): ?>
                    <tr id="display-row-<?= $q['question_id'] ?>">
                        <td style="text-align: center;"><?= htmlspecialchars($q['question_id']) ?></td>
                        <td style="text-align: center;"><?= htmlspecialchars($q['question_text']) ?></td>
                        <td style="text-align: center;"><?= htmlspecialchars($q['question_type']) ?></td>
                        <td style="text-align: center;"><?= htmlspecialchars($q['score']) ?></td>
                        <td style="text-align: center;">
                            <button class="type-btn" type="button" onclick="showEditForm(<?= $q['question_id'] ?>)">Edit</button>
                            <a href="index.php?mod=course&act=deletequestion&lesson_id=<?= $lesson_id ?>&course_id=<?= $course_id ?>&question_id=<?= $q['question_id'] ?>">
                                <button class="type-btn" type="button">Delete</button>
                            </a>
                        </td>
                    </tr>

                    <form method="POST" action="index.php?mod=course&act=updatequestion">
                        <tr id="edit-row-<?= $q['question_id'] ?>" style="display: none;">
                            <input type="hidden" name="question_id" value="<?= $q['question_id'] ?>">
                            <input type="hidden" name="lesson_id" value="<?= $lesson_id ?>">
                            <input type="hidden" name="course_id" value="<?= $course_id ?>">

                            <td><?= $q['question_id'] ?></td>
                            <td>
                                <input type="text" name="question_text" value="<?= htmlspecialchars($q['question_text']) ?>" required>
                                <div style="margin-top: 10px;">
                                    <?php foreach ($q['options'] as $opt): ?>
                                        <div style="margin-bottom: 6px;">
                                            <input type="text" name="options[<?= $opt['option_id'] ?>][text]" value="<?= htmlspecialchars($opt['option_text']) ?>" required style="width: 70%;">
                                            <label>
                                                <input type="checkbox" name="correct_option_<?= $q['question_id'] ?>" value="<?= $opt['option_id'] ?>" <?= $opt['is_correct'] ? 'checked' : '' ?>>
                                                Đúng
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>.
                            </td>
                            <td><?= htmlspecialchars($q['question_type']) ?></td>
                            <td><input type="number" name="score" value="<?= $q['score'] ?>" min="1" required></td>
                            <td>
                                <button class="type-btn" type="submit">Xong</button>
                                <button class="type-btn" type="button" onclick="hideEditForm(<?= $q['question_id'] ?>)">Hủy</button>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="button-group" style="margin-top: 20px;">
            <a href="index.php?mod=course&act=quiz&lesson_id=<?= $lesson_id ?>&course_id=<?= $course_id ?>" class="type-btn">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <script>
            function showEditForm(id) {
                document.getElementById('display-row-' + id).style.display = 'none';
                document.getElementById('edit-row-' + id).style.display = 'table-row';
            }

            function hideEditForm(id) {
                document.getElementById('edit-row-' + id).style.display = 'none';
                document.getElementById('display-row-' + id).style.display = 'table-row';
            }
        </script>
    </div>
</div>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 24px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    thead {
        background-color: #a34ef0;
        color: #ffffff;
    }

    th, td {
        padding: 14px 18px;
        text-align: left;
        border: none;
    }

    th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    td {
        font-size: 14px;
        color: #333;
        vertical-align: middle;
    }

    tbody tr:hover {
        background-color: #f9f6fd;
    }

    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }

        table {
            box-shadow: none;
        }

        thead {
            display: none;
        }

        tr {
            margin-bottom: 12px;
            background-color: #fff;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border-bottom: none;
        }

        td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #a34ef0;
            text-transform: capitalize;
        }
    }

    input[type="text"], input[type="number"] {
        width: 100%;
        padding: 6px 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus, input[type="number"]:focus {
        border-color: #a34ef0;
    }

    #quiz-form tr {
        vertical-align: middle;
    }

    .type-btn {
        padding: 6px 14px;
        border-radius: 20px;
        background-color: transparent;
        color: #a34ef0;
        border: 2px solid #a34ef0;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 2px 5px;
    }

    .type-btn:hover {
        background-color: #a34ef0;
        color: #fff;
    }

    tr[id^="edit-row-"] {
        background-color: #f4edfc;
    }
</style>

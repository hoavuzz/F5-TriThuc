<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang Chủ - E-Learning</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../public/css/site.css">
  <link rel="icon" type="favicon" href="../public/img/favicon.png" />
</head>
<style>
      /* Quiz.php */
      /* Giao diện tổng thể */
      .quiz-container-two {
          display: flex;
          flex-direction: column;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: #f9f9f9;
          padding: 30px;
      }

      /* Khung chính 2 phần */
      .activity-builder {
          display: flex;
          border: 1px solid #ccc;
          border-radius: 10px;
          overflow: hidden;
      }

      /* Sidebar bên trái */
      .sidebar {
          width: 220px;
          background-color: #1e1e2f;
          color: #fff;
          padding: 20px;
          border-right: 1px solid #333;
      }

      .sidebar h3 {
          font-size: 16px;
          margin-bottom: 10px;
      }

      .sidebar ul {
          list-style: none;
          padding: 0;
      }

      .sidebar li {
          padding: 10px;
          margin-bottom: 8px;
          border-radius: 6px;
          display: flex;
          align-items: center;
          gap: 10px;
          transition: 0.3s;
          cursor: pointer;
      }

      .sidebar li:hover {
          background-color: #2c2c44;
      }

      .sidebar li.active {
          background-color: #ffa500;
          color: #000;
      }

      /* Phần nội dung câu hỏi và thông tin */
      .question-types {
          flex: 1;
          display: flex;
          flex-direction: column;
          padding: 25px;
          gap: 30px;
          background: #fff;
      }

      /* Giao diện form chọn khóa học, bài học */
      .search-section h3 {
          font-size: 20px;
          margin-bottom: 15px;
          font-weight: bold;
          color: #333;
      }

      .search-section label {
          display: block;
          margin-bottom: 5px;
          font-weight: 600;
      }

      .search-section select {
          width: 100%;
          padding: 8px 12px;
          margin-bottom: 20px;
          border-radius: 5px;
          border: 1px solid #ccc;
          font-size: 15px;
      }

      .question-score {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 10px 0;
        font-family: Arial, sans-serif;
      }

      
      .question-score label {
        font-weight: bold;
        color: #333;
      }

      .question-score input[type="number"] {
        width: 80px;
        padding: 6px 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: border-color 0.3s, box-shadow 0.3s;
      }

      .question-score input[type="number"]:focus {
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0,123,255,0.4);
        outline: none;
      }


      /* Loại câu hỏi */
      .type-grid h4 {
          margin-bottom: 10px;
          font-weight: 600;
          font-size: 17px;
      }

      .question-buttons {
          display: flex;
          gap: 15px;
      }

      .type-btn {
          padding: 10px 15px;
          font-size: 15px;
          border-radius: 6px;
          border: 1px solid #ccc;
          background-color: #eee;
          cursor: pointer;
          transition: 0.3s;
      }

      .type-btn.selected {
          background-color: #ffa500;
          color: #fff;
          border-color: #ffa500;
      }

      /* Thanh trượt thời gian */
      .time-slider-container {
          margin-top: 20px;
          margin-bottom: 10px;
          display: flex;
          align-items: center;
          gap: 15px;
      }

      #time-range {
          width: 200px;
      }

      #time-display {
          font-weight: 600;
      }

      /* Nút tiếp tục */
      .mode-btn {
          margin-top: 10px;
          padding: 10px 18px;
          font-size: 16px;
          background-color: #ffa500;
          color: white;
          border: none;
          border-radius: 6px;
          cursor: pointer;
          transition: 0.3s;
      }

      .mode-btn:hover {
          background-color: #e69500;
      }

      /* Khung video hướng dẫn */
      .preview {
          margin-top: 40px;
          background-color: #f0f0f0;
          border-left: 5px solid #ffa500;
          padding: 15px;
          border-radius: 8px;
          display: flex;
          flex-direction: column;
          gap: 15px;
      }

      .preview video {
          max-width: 100%;
          border-radius: 8px;
      }

      .preview p {
          font-size: 14px;
          color: #333;
      }

      /* Responsive (đơn giản) */
      @media (max-width: 768px) {
          .activity-builder {
              flex-direction: column;
          }

          .sidebar {
              width: 100%;
              border-right: none;
              border-bottom: 1px solid #333;
          }

          .question-buttons {
              flex-direction: column;
          }

          .time-slider-container {
              flex-direction: column;
              align-items: flex-start;
          }
      }
      /* Quiz-upload-select.php */
          .quiz-builder {
            max-width: 900px;
            margin: 40px auto;
            padding: 24px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', sans-serif;
          }

          .section-title {
            display: block;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
          }

          .question-area textarea.question-input {
            width: 95%;
            min-height: 80px;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            resize: vertical;
          }

          .media-buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
          }

          .media-buttons button {
            padding: 8px 10px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.2s ease;
          }

          .media-buttons button:hover {
            background-color: #ddd;
          }

          .answers-area {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-top: 24px;
          }

          .answer-card {
            border-radius: 12px;
            padding: 12px;
            background-color: #f5f5f5;
            position: relative;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            transition: transform 0.2s ease;
          }

          .answer-card:hover {
            transform: translateY(-2px);
          }

          .answer-card textarea {
            width: 100%;
            min-height: 60px;
            border: none;
            background: transparent;
            font-size: 15px;
            resize: vertical;
            padding: 6px;
            outline: none;
          }

          .card-header {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 6px;
          }

          .card-header button {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #555;
          }

          .card-header button:hover {
            color: #000;
          }

          .mark-correct {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #eee;
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease;
          }

          .mark-correct:hover {
            background-color: #ccc;
          }

          .mark-correct i {
            color: green;
            font-size: 18px;
          }

          /* Màu đặc trưng cho mỗi card */
          .answer-card.blue { background-color: #e3f2fd; }
          .answer-card.green { background-color: #e8f5e9; }
          .answer-card.orange { background-color: #fff3e0; }
          .answer-card.red { background-color: #ffebee; }

          /* Nút điều hướng */
          .actions {
            margin-top: 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
          }

          .actions button {
            padding: 10px 16px;
            font-size: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            background-color: #eee;
            transition: background-color 0.2s ease;
          }

          .actions button:hover {
            background-color: #ccc;
          }

          .actions button.active {
            background-color: #90caf9;
            color: #fff;
            font-weight: bold;
          }

          .actions button.done {
            background-color: #4caf50;
            color: white;
          }

          .actions a {
            text-decoration: none;
          }

          /* Responsive nhỏ hơn 600px */
          @media (max-width: 600px) {
            .answers-area {
              grid-template-columns: 1fr;
            }

            .actions {
              flex-direction: column;
              align-items: stretch;
            }
          }

</style>
<body>
  <header>
    
    <a href="?page=home"><div class="logo">F5</div></a>
    <nav>
      <a href="#">Khóa học</a>
      <a href="?page=quiz">Quiz</a>
      <a href="#">Về chúng tôi</a>
      <a href="#">Đăng ký</a>
      <a href="#">Đăng nhập</a>
    </nav>
  </header>

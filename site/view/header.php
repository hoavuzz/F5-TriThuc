<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang Chủ - E-Learning</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <link rel="stylesheet" href="/F5-TRITHUC/public/css/site.css">

</head>
<body>
<header>
  <div class="logo">F5</div>

 
  <nav>
     <a href="index.php?mod=cart">Giỏ hàng</a>
    <a href="index.php?mod=page">Khóa học</a>
    <a href="#">Tài liệu</a>
    <a href="#">Về chúng tôi</a>

    <!-- Nếu chưa đăng nhập -->
    <?php if (!isset($_SESSION['user'])): ?>
      <div class="dropdown">
        <a href="javascript:void(0)" onclick="toggleDropdown('regDropdown')">Đăng ký</a>
        <div id="regDropdown" class="dropdown-content">
          <a href="index.php?mod=user&act=registerStudent">Đăng ký Sinh viên</a>
          <a href="index.php?mod=user&act=registerTeacher">Đăng ký Giảng viên</a>
        </div>
      </div>

      <div class="dropdown">
        <a href="javascript:void(0)" onclick="toggleDropdown('loginDropdown')">Đăng nhập</a>
        <div id="loginDropdown" class="dropdown-content">
          <a href="index.php?mod=user&act=loginStudent">Đăng nhập Sinh viên</a>
          <a href="index.php?mod=user&act=loginTeacher">Đăng nhập Giảng viên</a>
        </div>
      </div>
    <?php else: ?>
  <!-- Nếu đã đăng nhập -->
  <div class="dropdown">
    <a href="javascript:void(0)" onclick="toggleDropdown('userDropdown')">
      👤 <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
    </a>
    <div id="userDropdown" class="dropdown-content">
      <?php if ($_SESSION['user']['role'] === 'student'): ?>
          <a href="index.php?mod=user&act=profileStudent">Thông tin cá nhân</a>
      <?php elseif ($_SESSION['user']['role'] === 'teacher'): ?>
          <a href="index.php?mod=user&act=profileTeacher">Thông tin giảng viên</a>
      <?php endif; ?>
      <a href="index.php?mod=user&act=logout">Đăng xuất</a>
    </div>
  </div>
<?php endif; ?>

  </nav>
</header>

<script>
  function toggleDropdown(id) {
    let dropdowns = document.getElementsByClassName("dropdown-content");
    for (let i = 0; i < dropdowns.length; i++) {
      if (dropdowns[i].id !== id) {
        dropdowns[i].classList.remove("show");
      }
    }
    document.getElementById(id).classList.toggle("show");
  }

  // Ẩn dropdown khi click ra ngoài
  window.onclick = function(e) {
    if (!e.target.closest('.dropdown')) {
      let dropdowns = document.getElementsByClassName("dropdown-content");
      for (let i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.remove("show");
      }
    }
  }
</script>


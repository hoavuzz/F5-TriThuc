<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/F5-TRITHUC/public/css/admin.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">F5</div>
      <nav>
        <a class="active" href="index.php?mod=page">Dashboard</a>
       <a href="index.php?mod=user">Users</a>
        <a href="index.php?mod=course">Course</a>
         <a href="index.php?mod=category">Danh muc</a>
        <a href="#">Orders</a>
        <a href="index.php?mod=lesson">Analytics</a>
        <a href="#">Settings</a>
        <a href="index.php?mod=listTeachers">teacher</a>
      </nav>
      <button class="logout">Logout</button>
    </aside>
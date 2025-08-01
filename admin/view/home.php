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
        <a class="active" href="#">Dashboard</a>
       <a href="index.php?mod=user">Users</a>
        <a href="#">Course</a>
        <a href="#">Orders</a>
        <a href="#">Analytics</a>
        <a href="#">Settings</a>
      </nav>
      <button class="logout">Logout</button>
    </aside>

    <!-- Main Content -->
    <main class="main">
      <header class="topbar">
        <h2>User Management</h2>
        <div class="search-wrapper">
          <input type="text" placeholder="Search..." />
        </div>
        <div class="profile">
          <span class="bell">🔔<span class="badge">3</span></span>
          <span class="admin">Admin User</span>
        </div>
      </header>

      <div class="filters">
        <input type="text" placeholder="Search users..." />
        <select>
          <option>All Roles</option>
          <option>Admin</option>
          <option>Manager</option>
          <option>Customer</option>
        </select>
        <select>
          <option>All Status</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
        <button class="create-btn">+ Create New User</button>
      </div>

      <table class="user-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Join Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>#001</td>
            <td><img src="https://i.pravatar.cc/30?img=1" alt=""> John Smith</td>
            <td>john.smith@email.com</td>
            <td><span class="role admin">Admin</span></td>
            <td><span class="status active">Active</span></td>
            <td>Jan 15, 2024</td>
            <td><span class="action edit">✏️</span> <span class="action delete">🗑️</span></td>
          </tr>
          <tr>
            <td>#002</td>
            <td><img src="https://i.pravatar.cc/30?img=2" alt=""> Sarah Johnson</td>
            <td>sarah.johnson@email.com</td>
            <td><span class="role customer">Customer</span></td>
            <td><span class="status active">Active</span></td>
            <td>Jan 12, 2024</td>
            <td><span class="action edit">✏️</span> <span class="action delete">🗑️</span></td>
          </tr>
          <tr>
            <td>#003</td>
            <td><img src="https://i.pravatar.cc/30?img=3" alt=""> Mike Davis</td>
            <td>mike.davis@email.com</td>
            <td><span class="role manager">Manager</span></td>
            <td><span class="status inactive">Inactive</span></td>
            <td>Jan 10, 2024</td>
            <td><span class="action edit">✏️</span> <span class="action delete">🗑️</span></td>
          </tr>
          <tr>
            <td>#004</td>
            <td><img src="https://i.pravatar.cc/30?img=4" alt=""> Emily Wilson</td>
            <td>emily.wilson@email.com</td>
            <td><span class="role customer">Customer</span></td>
            <td><span class="status active">Active</span></td>
            <td>Jan 08, 2024</td>
            <td><span class="action edit">✏️</span> <span class="action delete">🗑️</span></td>
          </tr>
        </tbody>
      </table>

      <div class="pagination">
        <button class="page active">1</button>
        <button class="page">2</button>
        <button class="page">3</button>
        <button class="page">...</button>
        <button class="page">10</button>
      </div>
    </main>
  </div>
</body>
</html>

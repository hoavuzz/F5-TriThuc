
     <!-- Main Content -->
    <main class="main">
      <header class="topbar">
        <h2>LESSON</h2>
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
        <a href="index.php?mod=lesson&act=add"><button class="create-btn">+ Create New User</button></a> 
      </div>

      <table class="user-table">
        <thead>
          <tr>
            <th>ID</th>
        <th>Khóa học ID</th>
        <th>Tiêu đề</th>
        <th>Trạng thái</th>
        <th>Ngày tạo</th>
        <th>Ngày cập nhật</th>
        <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lessons as $l): ?>
    <tr>
        <td><?= $l['lesson_id'] ?></td>
        <td><?= $l['course_id'] ?></td>
        <td><?= htmlspecialchars($l['title']) ?></td>
       
        <td><?= $l['status'] == 1 ? 'Kích hoạt' : 'Ẩn' ?></td>
        <td><?= $l['created_at'] ?></td>
        <td><?= $l['updated_at'] ?></td>
        <td>
            <a href="index.php?mod=lesson&act=edit&id=<?= $l['lesson_id'] ?>">Sửa</a> |
            <a href="index.php?mod=lesson&act=delete&id=<?= $l['lesson_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
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





    <!-- Main Content -->
    <main class="main">
      <header class="topbar">
        <h2>COURSE</h2>
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
        <a href="index.php?mod=course&act=add"><button class="create-btn">+ Create New User</button></a> 
      </div>

      <table class="user-table">
        <thead>
          <tr>
            <th>ID</th>
        <th>Teacher ID</th>
        <th>Tên danh mục</th>
        <th>Tên khóa học</th>
        <th>Ảnh</th>
        <th>Giá</th>
        <th>Ngôn ngữ</th>
        <th>Lượt xem</th>
        <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($courses) && is_array($courses)): ?>
        <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= $c['course_id'] ?></td>
            <td><?= $c['teacher_id'] ?></td>
            <td><?= htmlspecialchars($c['category_name']) ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td>
                <?php if (!empty($c['image'])): ?>
                    <img src="../uploads/courses/<?= $c['image'] ?>" width="80">
                <?php endif; ?>
            </td>
            <td><?= number_format($c['price'], 0, ',', '.') ?> ₫</td>
            <td><?= htmlspecialchars($c['language']) ?></td>
            <td><?= $c['views'] ?></td>
            <td>
                <a href="index.php?mod=course&act=edit&id=<?= $c['course_id'] ?>">Sửa</a> | 
                <a href="index.php?mod=course&act=delete&id=<?= $c['course_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="text-align:center;">Chưa có khóa học nào</td>
        </tr>
    <?php endif; ?>
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


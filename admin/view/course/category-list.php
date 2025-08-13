<!-- Main Content -->
<main class="main">
  <header class="topbar">
    <h2>CATEGORY</h2>
    <div class="search-wrapper">
      <input type="text" placeholder="Search..." />
    </div>
    <div class="profile">
      <span class="bell">🔔<span class="badge">3</span></span>
      <span class="admin">Admin User</span>
    </div>
  </header>

  <div class="filters">
    <input type="text" placeholder="Search categories..." />
    <!-- Đã bỏ phần chọn trạng thái -->
    <a href="index.php?mod=category&act=add">
      <button class="create-btn">+ Create New Category</button>
    </a>
  </div>

  <table class="user-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên danh mục</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($categories) && is_array($categories)): ?>
        <?php foreach ($categories as $c): ?>
          <tr>
            <td><?= $c['category_id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td>
              <a href="index.php?mod=category&act=edit&id=<?= $c['category_id'] ?>">Sửa</a> | 
              <a href="index.php?mod=category&act=delete&id=<?= $c['category_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="3" style="text-align:center;">Chưa có danh mục nào</td>
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

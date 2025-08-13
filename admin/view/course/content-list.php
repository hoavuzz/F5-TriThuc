

    <!-- Main Content -->
    <main class="main">
      <header class="topbar">
        <h2>CONTENT</h2>
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
        <a href="index.php?mod=content&act=add"><button class="create-btn">+ Create New User</button></a> 
      </div>

      <table class="user-table">
        <thead>
          <tr>
            <th>ID</th>
        <th>Bài học</th>
        <th>Nội dung</th>
        <th>Ngày tạo</th>
        <th>Video_link</th>
        <th>Content_t</th>
        <th>khoảng thời gian</th>
        <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php foreach ($contents as $c): ?>
    <tr>
        <td><?= $c['content_id'] ?></td>
        
        <td><?= htmlspecialchars($c['lesson_title']) ?></td>
        <td><?= nl2br(htmlspecialchars(mb_strimwidth($c['content'] ?? '', 0, 50, "..."))) ?></td>
        <td><?= $c['created_at'] ?></td>
        <td><?= $c['video_link'] ?></td>
        <td><?= $c['content_type'] ?></td>
        <td><?= $c['duration'] ?></td>
        <td>
            <a href="index.php?mod=content&act=edit&id=<?= $c['content_id'] ?>">Sửa</a> |
            <a href="index.php?mod=content&act=delete&id=<?= $c['content_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
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




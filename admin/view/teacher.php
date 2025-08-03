<table border="1">
  <tr>
    <th>ID</th>
    <th>Email</th>
    <th>Username</th>
    <th>Hành động</th>
  </tr>
  <?php foreach($pendingTeachers as $t): ?>
  <tr>
    <td><?= $t['user_id'] ?></td>
    <td><?= $t['email'] ?></td>
    <td><?= $t['username'] ?></td>
    <td>
      <a href="index.php?mod=admin&act=approveTeacher&user_id=<?= $t['user_id'] ?>">Duyệt</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

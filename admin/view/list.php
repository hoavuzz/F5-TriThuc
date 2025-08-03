<h2>Danh sách khóa học</h2>
<a href="index.php?mod=course&act=add">+ Thêm Khóa Học</a>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên khóa học</th>
        <th>Ảnh</th>
        <th>Giá</th>
        <th>Ngôn ngữ</th>
        <th>Lượt xem</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($courses as $c): ?>
    <tr>
        <td><?= $c['course_id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td>
            <?php if ($c['image']): ?>
                <img src="/F5-TRITHUC/uploads/courses/<?= $c['image'] ?>" width="80">
            <?php endif; ?>
        </td>
        <td><?= $c['price'] ?></td>
        <td><?= $c['language'] ?></td>
        <td><?= $c['views'] ?></td>
        <td>
            <a href="index.php?mod=course&act=edit&id=<?= $c['course_id'] ?>">Sửa</a> | 
            <a href="index.php?mod=course&act=delete&id=<?= $c['course_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
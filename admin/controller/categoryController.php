<?php
require_once "conf.php";
require_once "../admin/model/CategoryModel.php";

$CategoryModel = new CategoryModel($pdo);

$act = $_GET['act'] ?? 'list';

switch ($act) {
    case 'list':
        $categories = $CategoryModel->getAllCategories();
        include "../admin/view/course/category-list.php";
        break;

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name']
            ];
            $CategoryModel->addCategory($data);
            header("Location: index.php?mod=category&act=list");
            exit;
        }
        include "../admin/view/course/category-add.php";
        break;

    case 'edit':
        $id = $_GET['id'] ?? 0;
        $category = $CategoryModel->getCategoryById($id);
        if (!$category) {
            die("Danh mục không tồn tại!");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name']
            ];
            $CategoryModel->updateCategory($id, $data);
            header("Location: index.php?mod=category&act=list");
            exit;
        }
        include "../admin/view/course/category-edit.php";
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $CategoryModel->deleteCategory($id);
        header("Location: index.php?mod=category&act=list");
        break;

    default:
        echo "Không tìm thấy chức năng!";
        break;
}

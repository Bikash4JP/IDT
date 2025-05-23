<?php
ini_set('session.cookie_path', '/itf');
session_start();
header("Content-Type: application/json");

// Check if user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "ログインしてください。"]);
    exit;
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "無効なリクエストです。"]);
    exit;
}

// Include database connection
require_once 'db_connect.php';

try {
    $form_type = $_POST['form_type'] ?? '';
    $post_type = $_POST['post_type'] ?? ($form_type === 'jobs' ? 'job' : 'news');
    $title = $_POST['title'] ?? '';
    $summary = $_POST['summary'] ?? null;
    $content = $_POST['content'] ?? null;
    $category = $_POST['category'] ?? null;
    $date = date('Y-m-d'); // Only date (YYYY-MM-DD)
    $posted_by = $_SESSION['username'];
    $staff_id = $_SESSION['id'];

    // Handle image upload
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        // Ensure the uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $image_path = $upload_dir . $image_name;

        // Validate image file (JPEG or PNG, max 2MB)
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        $file_size = $_FILES['image']['size'];

        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(["success" => false, "message" => "画像はJPEGまたはPNG形式である必要があります。"]);
            exit;
        }
        if ($file_size > $max_size) {
            echo json_encode(["success" => false, "message" => "画像サイズは2MB以下である必要があります。"]);
            exit;
        }

        // Move uploaded file to uploads directory
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            echo json_encode(["success" => false, "message" => "画像のアップロードに失敗しました。"]);
            exit;
        }
    } elseif (isset($_SESSION['preview_image']) && !empty($_SESSION['preview_image'])) {
        $image_path = $_SESSION['preview_image'];
    }

    // Job-specific fields (made optional since not all are in the form)
    $company_name = $_POST['company_name'] ?? null;
    $job_location = $_POST['job_location'] ?? null;
    $job_category = $_POST['job_category'] ?? null;
    $job_type = $_POST['job_type'] ?? null;
    $salary = $_POST['salary'] ?? null;
    $bonuses = isset($_POST['bonuses']) ? (int)$_POST['bonuses'] : null;
    $bonus_amount = $_POST['bonus_amount'] ?? null;
    $living_support = isset($_POST['living_support']) ? (int)$_POST['living_support'] : null;
    $rent_support = $_POST['rent_support_amount'] ?? null;
    $insurance = isset($_POST['insurance']) ? (int)$_POST['insurance'] : null;
    $transportation_charges = isset($_POST['transportation_charges']) ? (int)$_POST['transportation_charges'] : null;
    $transport_amount_limit = $_POST['transport_amount'] ?? null;
    $salary_increment = isset($_POST['salary_increment']) ? (int)$_POST['salary_increment'] : null;
    $increment_condition = $_POST['increment_condition'] ?? null;
    $japanese_level = $_POST['japanese_level'] ?? null;
    $experience = $_POST['experience'] ?? null;
    $minimum_leave_per_year = $_POST['minimum_leave_per_year'] ?? null;
    $employee_size = $_POST['employee_size'] ?? null;
    $required_vacancy = $_POST['required_vacancy'] ?? null;

    // Validate required fields based on form type
    if ($form_type === 'posts') {
        if (empty($title) || empty($summary) || empty($category) || empty($content)) {
            echo json_encode(["success" => false, "message" => "必須フィールドを入力してください。"]);
            exit;
        }
    } elseif ($form_type === 'jobs') {
        if (empty($title) || empty($job_type) || empty($content)) {
            echo json_encode(["success" => false, "message" => "必須フィールドを入力してください。"]);
            exit;
        }
    }

    // Insert into posts table (removed created_at as it will be set automatically by the database)
    $stmt = $pdo->prepare("
        INSERT INTO posts (
            staff_id, post_type, category, title, summary, content, image, company_name, 
            job_location, job_category, job_type, salary, bonuses, bonus_amount, 
            living_support, rent_support, insurance, transportation_charges, 
            transport_amount_limit, salary_increment, increment_condition, 
            japanese_level, experience, minimum_leave_per_year, employee_size, 
            required_vacancy, date, posted_by
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, 
            ?, ?, ?, 
            ?, ?, ?, ?, 
            ?, ?, ?
        )
    ");
    $stmt->execute([
        $staff_id, $post_type, $category, $title, $summary, $content, $image_path, $company_name,
        $job_location, $job_category, $job_type, $salary, $bonuses, $bonus_amount,
        $living_support, $rent_support, $insurance, $transportation_charges,
        $transport_amount_limit, $salary_increment, $increment_condition,
        $japanese_level, $experience, $minimum_leave_per_year, $employee_size,
        $required_vacancy, $date, $posted_by
    ]);

    // Clear session preview data
    unset($_SESSION['preview_title']);
    unset($_SESSION['preview_content']);
    unset($_SESSION['preview_summary']);
    unset($_SESSION['preview_category']);
    unset($_SESSION['preview_form_type']);
    unset($_SESSION['preview_image']);

    echo json_encode(["success" => true, "message" => "投稿が完了しました！"]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "エラーが発生しました：" . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "予期せぬエラーが発生しました：" . $e->getMessage()]);
}
?>
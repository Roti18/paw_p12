<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT profile_image FROM students WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $image_path = 'uploads/' . $row['profile_image'];
        if (file_exists($image_path) && !is_dir($image_path)) {
            unlink($image_path);
        }
    }

    $deleteSql = "DELETE FROM students WHERE id=$id";
    if (mysqli_query($conn, $deleteSql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
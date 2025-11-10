<?php
include 'db.php';

$id = '';
$name = '';
$price = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $old_image = $_POST['old_image'];

    $image = $old_image;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (!empty($old_image) && file_exists($target_dir . $old_image)) {
            unlink($target_dir . $old_image);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $image_name;
        }
    }

    $sql = "UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} 

else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $price = $row['price'];
        $image = $row['image'];
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if(isset($_POST['batal'])){
  header('Location: ./index.php');
}
?>

<form method='POST' action='edit.php' enctype='multipart/form-data'>
  <input type='hidden' name='id' value='<?php echo $id; ?>'>
  <input type='hidden' name='old_image' value='<?php echo $image; ?>'>

  Nama: <input type='text' name='name' value='<?php echo $name; ?>' required><br>
  Harga: <input type='number' name='price' value='<?php echo $price; ?>' required><br>

  Gambar Saat Ini: <br>
  <?php if ($image) { ?>
  <img src='uploads/<?php echo $image; ?>' width='100'><br>
  <?php } ?>

  Ganti Gambar: <input type='file' name='image'><br>

  <button type='submit' name="batal">Batal</button>
  <button type='submit'>Update</button>
</form>
<?php
include 'db.php';

$id = '';
$name = '';
$gender = '';
$birth_date = '';
$class = '';
$address = '';
$profile_image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $class = $_POST['class'];
    $address = $_POST['address'];
    $old_image = $_POST['old_image'];

    $profile_image = $old_image;

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (!empty($old_image) && file_exists($target_dir . $old_image)) {
            unlink($target_dir . $old_image);
        }

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_image = $image_name;
        }
    }

    $sql = "UPDATE students SET name='$name', gender='$gender', birth_date='$birth_date', class='$class', address='$address', profile_image='$profile_image' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $gender = $row['gender'];
        $birth_date = $row['birth_date'];
        $class = $row['class'];
        $address = $row['address'];
        $profile_image = $row['profile_image'];
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
  <input type='hidden' name='old_image' value='<?php echo $profile_image; ?>'>

  Nama: <input type='text' name='name' value='<?php echo $name; ?>' required><br>
  Jenis Kelamin:
  <select name='gender' required>
    <option value='L' <?php if($gender == 'L') echo 'selected'; ?>>Laki-laki</option>
    <option value='P' <?php if($gender == 'P') echo 'selected'; ?>>Perempuan</option>
  </select><br>
  Tanggal Lahir: <input type='date' name='birth_date' value='<?php echo $birth_date; ?>' required><br>
  Kelas: <input type='text' name='class' value='<?php echo $class; ?>' required><br>
  Alamat: <textarea name='address'><?php echo $address; ?></textarea><br>

  Gambar Profil Saat Ini: <br>
  <?php if ($profile_image) { ?>
  <img src='uploads/<?php echo $profile_image; ?>' width='100'><br>
  <?php } ?>

  Ganti Gambar Profil: <input type='file' name='profile_image'><br>

  <button type='submit' name="batal">Batal</button>
  <button type='submit'>Update</button>
</form>
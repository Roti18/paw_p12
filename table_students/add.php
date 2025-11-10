<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $class = $_POST['class'];
    $address = $_POST['address'];
    
    $profile_image = $_FILES['profile_image']['name'];
    $target = 'uploads/' . basename($profile_image);

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
        $sql = "INSERT INTO students (name, gender, birth_date, class, address, profile_image) VALUES ('$name', '$gender', '$birth_date', '$class', '$address', '$profile_image')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        echo 'Upload file gagal!';
    }
}
?>

<form method='POST' enctype='multipart/form-data'>
  Nama: <input type='text' name='name' required><br>
  Jenis Kelamin:
  <select name='gender' required>
    <option value='L'>Laki-laki</option>
    <option value='P'>Perempuan</option>
  </select><br>
  Tanggal Lahir: <input type='date' name='birth_date' required><br>
  Kelas: <input type='text' name='class' required><br>
  Alamat: <textarea name='address'></textarea><br>
  Gambar Profil: <input type='file' name='profile_image'><br>
  <button type='submit' name='submit'>Simpan</button>
</form>
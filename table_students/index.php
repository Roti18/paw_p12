<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$countSql = "SELECT COUNT(*) AS total FROM students WHERE name LIKE '%$search%'";
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$total = $countRow['total'];
$pages = ceil($total / $limit);

$sql = "SELECT * FROM students WHERE name LIKE '%$search%' LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<form method='GET'>
  <input type='text' name='search' placeholder='Cari berdasarkan nama...' value='<?php echo $search; ?>'>
  <button type='submit'>Cari</button>
</form>

<a href='add.php'>+ Tambah Siswa Baru</a>

<table border='1' cellpadding='10'>
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Tanggal Lahir</th>
    <th>Kelas</th>
    <th>Gambar Profil</th>
    <th>Alamat</th>
    <th>Aksi</th>
  </tr>

  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['gender']; ?></td>
    <td><?php echo $row['birth_date']; ?></td>
    <td><?php echo $row['class']; ?></td>
    <td><img src='uploads/<?php echo $row['profile_image']; ?>' width='80'></td>
    <td><?php echo $row['address']; ?></td>
    <td>
      <a href='edit.php?id=<?php echo $row['id']; ?>'>Edit</a> |
      <a href='delete.php?id=<?php echo $row['id']; ?>' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
    </td>
  </tr>
  <?php } ?>
</table>

<?php for ($i = 1; $i <= $pages; $i++) { ?>
<a href='?page=<?php echo $i; ?>&search=<?php echo $search; ?>'><?php echo $i; ?></a>
<?php } ?>
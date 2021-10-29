<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "dblatihan";


$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));


//jika button disimpan dan diklik 
if (isset($_POST['bsimpan'])) {
    //pengujian data apabila diedit atau disimpan baru
    if ($_GET['hal'] == "edit") {
        //Data akan simpan baru
        $edit = mysqli_query($koneksi, "UPDATE tmhs set 
                                            nim='$_POST[tnim]',
                                            nama = '$_POST[tnama]',
                                            alamat = '$_POST[talamat]',
                                            prodi = '$_POST[tprodi]'
                                            WHERE id_mhs = '$_GET[id]'
                                            ");

        if ($edit) {
            echo "<script>
                            alert('data berhasil diedit');
                            document.location='index.php';
                        </script>";
        } else {
            echo "<script>
                        alert('data gagal diedit');
                        document.location='index.php';
                    </script>";
        }
    } else {
        //Data akan simpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim,nama,alamat,prodi) VALUES ('$_POST[tnim]','$_POST[tnama]','$_POST[talamat]','$_POST[tprodi]')");

        if ($simpan) {
            echo "<script>
                    alert('data berhasil disimpan');
                    document.location='index.php';
                </script>";
        } else {
            echo "<script>
                alert('data gagal disimpan');
                document.location='index.php';
            </script>";
        }
    }
}


//pengujian jika button diklik edit/hapus 
if (isset($_GET['hal'])) {
    //pengujian data yang akan diedit
    if ($_GET['hal'] == "edit") {
        //tampilan data yang diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs= '$_GET[id]'");
        $data = mysqli_fetch_assoc($tampil);
        if ($data) {
            //jika data ditemukan maka akan ditampung oleh variable
            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vprodi = $data['prodi'];
        }
    } else if ($_GET['hal'] == "hapus") {
        //persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
                     alert('data berhasil dihapus');
                    document.location='index.php';
                </script>";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Data CRUD Mahasiswa</title>
</head>

<body>

    <div class="container">
        <h2 class="text-center">CRUD Mahasiswa</h2>
        <p class="text-center">bootstrap 5 with PHP</p>

        <div class="row">
            <div class="col-md-12">
                <div class="mx-auto">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Form Input Mahasiswa
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="">Nim</label>
                                    <input type="text" name="tnim" value="<?= $vnim ?>" class="form-control mt-1 " placeholder="Masukan nim" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="">Nama</label>
                                    <input type="text" name="tnama" value="<?= $vnama ?>" class="form-control mt-1" placeholder="Masukan Nama" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="">Alamat</label>
                                    <textarea name="talamat" class="form-control mt-2" placeholder="Masukan alamat"><?= $valamat ?></textarea>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="">Program Studi</label>
                                    <select name="tprodi" value="" class="form-control">
                                        <option value="<?= $vprodi ?>"><?= $vprodi ?></option>
                                        <option value="D3-MI">D3-MI</option>
                                        <option value="S1-SI">S1-SI</option>
                                        <option value="S1-TI">S1-TI</option>
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-danger mt-3" name="bsimpan">Simpan</button>
                                <button type="reset" class="btn btn-warning mt-3" name="breset">Kosongkan Data</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Form Input Mahasiswa
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>NO</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Program Studi</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs ORDER BY id_mhs desc");
                                while ($data = mysqli_fetch_assoc($tampil)) :

                                ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $data['nim']; ?></td>
                                        <td><?= $data['nama']; ?></td>
                                        <td><?= $data['alamat']; ?></td>
                                        <td><?= $data['prodi']; ?></td>
                                        <td>
                                            <a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" onclick="return confirm('Hapus data?')" class="btn btn-danger">Hapus</a>
                                            <a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
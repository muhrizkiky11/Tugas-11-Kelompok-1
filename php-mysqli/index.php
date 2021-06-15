<?php
$host           = "localhost";
$user           = "root";
$pass           = "";
$db             = "akademik1";

$koneksi        = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$npm            ="";
$nama           ="";
$alamat         ="";
$fakultas       ="";
$sukses         ="";
$error          ="";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id         = $GET['id'];
    $sql1       = "delete from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);

}

if($op == 'edit'){
    $id         = $_GET['id'];
    $sql1       = "select * from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    $r1         = mysqli_fetch_array($q1);
    $npm        = $r1['npm'];
    $nama       = $r1['nama'];
    $alamat     = $r1['alamat'];
    $fakultas   = $r1['fakultas'];

    if($npm == ''){
        $error = "Data tidak ditemukan";
    }
}
if(isset($_POST['simpan'])) { //untuk create
$npm            = $_POST['npm'];
$nama           = $_POST['nama'];
$alamat         = $_POST['alamat'];
$fakultas       = $_POST['fakultas'];

    if($npm && $nama && $alamat && $fakultas) {
        if($op == 'edit'){ //untuk update
            $sql1       = "update mahasiswa set npm = '$npm',nama='$nama',alamat = '$alamat',fakultas='$fakultas' where id = '$id'";
            $q1         = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data berhasil diupadete";
            }else{
                $error  = "Data gagal diupdate";
            }
        }else{ //untuk insert
            $sql1       = "insert into mahasiswa(npm,nama,alamat,fakultas) values('$npm','$nama','$alamat','$fakultas')";
        $q1       = mysqli_query($koneksi,$sql1);
        if ($q1) {
            $sukses         = "Berhasil memasukkan data baru";
        } else{
            $error          = "Gagal memasukkan data";
        }    
        }
    }else{
        $error= "Silahkan masukkan semua data";
    }
}   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                   </div>
                <?php  header("refresh:5;url=index.php"); //5 = detik
                }
                ?>
                <?php
                if($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                   </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="npm"  name="npm" value=" <?php echo $npm?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama"  name="nama" value=" <?php echo $nama?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat"  name="alamat" value=" <?php echo $alamat?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                
                            <option value="">- Pilih Fakultas</option>
                            <option value="saintek" <?php if($fakultas == "saintek") echo "selected"?>>Saintek</option> 
                             <option value="soshum" <?php if($fakultas == "soshum") echo "selected"?>>Soshum</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NPM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2   = "select * from mahasiswa order by id desc";
                            $q2     = mysqli_query($koneksi,$sql2);
                            $urut   = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id          = $r2['id'];
                                $npm         = $r2['npm'];
                                $nama        = $r2['nama'];
                                $alamat      = $r2['alamat'];
                                $fakultas    = $r2['fakultas'];
                            }
                            ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $npm ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $fakultas ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button</a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onlclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    
                               
                                </td>
                            </tr>
                            <?php 
                            
                            ?>
                            
                            
                        </tbody>
                    </thead>

            </div>
        </div>
    </div>
</body>

</html>
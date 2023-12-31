<?php

session_start();

// cek user login
if (!isset($_SESSION["loginadmin"])) {
    header("Location: login.php");
    exit;
}

// koneksi
require '../functions.php';

// query product
$product = query("SELECT * FROM product");

// tombol cari di ketik
if (isset($_POST["cari"])) {
    $product = cari($_POST["keyword"]);
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/index.css">

    <!-- Font Goole -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <title>Product</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-lg fixed-top">
        <div class="container">
            <a class="navbar-brand">Gudang Computer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-bold text-uppercase">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="orderlist.php">Order List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="product.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logoutadmin.php"
                            onclick="return confirm('Are You Sure?')">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    <section id="container" class="container">

        <!-- Header -->
        <section class="jumbotron text-center mb-5" style="margin-top: 100px;">
            <h1 class="display-5 text-uppercase fw-bold">Product</h1>
            <hr class="text-success underline">
        </section>
        <!-- Akhir Header -->

        <!-- Tambah Data -->
        <a href="add.php" class="d-inline-block float-start">
            <button class="btn btn-success fw-bold text-uppercase">Add Product</button>
        </a>
        <!-- Akhir Tambah Data -->

        <!-- Search -->
        <form action="" method="post">
            <input class="form-control container mb-3 w-25 float-end" type="search" list="datalistOptions" id="keyword"
                name="keyword" autocomplete="off" placeholder="Type to search...">
            <button type="submit" name="cari" id="tombol-cari"
                class="btn btn-success ms-1 text-uppercase fw-bold float-end d-none">Cari</button>
        </form>
        <!-- Akhir Search -->

        <!-- Tables -->
        <div id="container">
            <table class="table bg-success container text-center text-white mb-5 fw-bold">
                <tr class="text-uppercase">
                    <th>No</th>
                    <th>Action</th>
                    <th>Name</th>
                    <th>Specification</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>

                <?php $i = 1; ?>
                <?php foreach ($product as $row) : ?>

                <tr>
                    <td><?= $i ?></td>
                    <td class="fs-5">
                        <a onclick="return confirm('Are You Sure?')" class="text-white"
                            href="delete.php?id=<?= $row["id"] ?>"><i class="bi bi-trash-fill"></i></a>
                        |
                        <a class="text-white" href="change.php?id=<?= $row["id"] ?>"><i
                                class="bi bi-pencil-square"></i></a>
                    </td>
                    <td><?= $row["nama"] ?></td>
                    <td><a class="text-white" href="<?= $row["spesifikasi"] ?>" target="_blank">CLICK HERE</a></td>
                    <td><?= $row["stock"] ?></td>
                    <td><?= rupiah($row["price"]) ?></td>
                    <td><a href="../image/product/<?= $row["gambar"] ?>" target="_blank"><img
                                src="../image/product/<?= $row["gambar"] ?>" alt="" width="80px"></a></td>
                </tr>

                <?php $i++ ?>
                <?php endforeach; ?>

            </table>
        </div>
        <!-- Akhir Tables -->

    </section>

    <!-- Footer -->
    <footer id="footer" class="py-4 bg-success position-relative mt-5">
        <div class="container-md text-center text-white fs-6">
            <p class="my-0">&copy; Copyright <span class="fw-bold">gudangcomputer</span>. All Rights Reserved.</p>
            <p class="my-0">
                Created & Design
                by
                <span class="fw-bold">@@DUWIAAW.</span>
            </p>
        </div>
    </footer>
    <!-- Akhir Footer -->

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
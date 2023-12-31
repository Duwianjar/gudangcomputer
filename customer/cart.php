<?php

session_start();

// koneksi 
require '../functions.php';


// cek user login
if (!isset($_SESSION["login"])) {
    // jika belom
    header("Location: login.php");
} else {
    // jika sudah, ambil id nya
    $user_id = $_SESSION['id'];
}

// fungsi checkout
if (isset($_GET['id'])) {
    $cart = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user_id'");
    if (mysqli_num_rows($cart) > 0) {
        while ($fetch = mysqli_fetch_assoc($cart)) {
            $_SESSION['quantity'] = $fetch['quantity'];
        }
    }
}


// fungsi remove
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($db, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
    header('location:cart.php');
}

// fungsi delete all
if (isset($_GET['delete_all'])) {
    mysqli_query($db, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
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

    <!-- Font Goole -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/market.css">

    <!-- Bootsrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <title>Gudang Computer Cart</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Gudang Computer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-uppercase">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../index.php">Home <i class="bi bi-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="cart.php">Cart <i class="bi bi-cart3"></i></a>
                    </li>

                    <?php
                    // cek apakah user sudah login
                    if (!isset($_SESSION['login'])) {
                        echo '
                    <li class="nav-item">
                        <a class="nav-link text-white"
                        href="login.php">Login
                        <i class="bi bi-box-arrow-in-right"></i></a>
                    </li>
                    ';
                    } else {
                        // jika sudah login
                        echo '
                    <li class="nav-item">
                        <a class="nav-link text-white" href="profile.php">Profile
                        <i class="bi bi-person-circle"></i></a>
                    </li>
                        ';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Search -->
    <section id="search" class="navbar navbar-expand-lg bg-secondary">
        <div class="navbar-collapse d-flex justify-content-center">
            <form method="get" action="seacrh.php" class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword"
                    autocomplete="off">
                <button class="btn btn-success" name="cari" id="tombol-cari"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </section>
    <!-- Akhir Search -->
    <!-- Akhir Navbar -->

    <!-- Alert -->
    <section class="container mb-5">
        <div class="alert alert-warning d-flex align-items-center mt-3 border border-secondary" role="alert">
            <div class="text-dark fw-bold">
                <i class="bi bi-box"></i> Choose the Free Shipping voucher to enjoy Free Shipping. Happy Shopping !
            </div>
        </div>

        <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message container-sm alert alert-warning d-flex align-items-center border border-secondary fw-bold text-dark" onclick="this.remove();">' . $message . '</div>';
            }
        }
        ?>
        <!-- Akhir Alert -->

        <!-- Cart -->
        <section id="page-cart" style="height:100vh;">
            <div class="table-responsive">
                <table class="table bg-success container text-center text-white mb-1 fw-bold">

                    <thead class="text-uppercase">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php
                        $cart_query = mysqli_query($db, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                        $grand_total = 0;
                        if (mysqli_num_rows($cart_query) > 0) {
                            while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                        ?>
                        <td><img src="../image/product/<?php echo $fetch_cart['image']; ?>" height="80" width="80px"
                                alt=""></td>
                        <td class="text-truncate">
                            <?php echo $fetch_cart['name']; ?>
                        </td>
                        <td><?php echo rupiah($fetch_cart['price']); ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <p><?php echo $fetch_cart['quantity']; ?></p>
                            </form>
                        </td>

                        <?php $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                        <td>
                            <!-- <a class="delete-btn">
                                <button class="btn btn-success btn-sm uppercase fw-bold fs-3 d-inline">
                                    <i class="bi bi-credit-card"></i>
                                </button>
                            </a> -->


                            <a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn"
                                onclick="return confirm('remove item from cart?');">
                                <button class="btn btn-success btn-sm d-inline">
                                    <i class="bi bi-trash-fill text-white fs-3 ms-1"></i>
                                </button>
                            </a>
                        </td>
                        </tr>
                        <?php
                                $grand_total += $sub_total;
                            }
                        } else {
                            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                        }
                        ?>
                        <tr class="table-bottom">
                            <td colspan="3">Subtotal :</td>
                            <td><?php echo rupiah($grand_total); ?></td>
                            <td><a href="cart.php?delete_all" onclick="return confirm('delete all from cart?');"
                                    class="delete-btn text-white<?php echo ($grand_total > 1) ? '' : 'disabled d-none'; ?>">DELETE
                                    ALL
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
    <!-- Akhir Cart -->

    <!-- Footer -->
    <footer id="footer" class="py-4 bg-success position-relative">
        <div class="container-md text-center text-white fs-6">
            <p class="my-0">&copy; Copyright <span class="fw-bold">gudangcomputer</span>. All Rights Reserved.</p>
            <p class="my-0">
                Created & Design
                by
                <span class="fw-bold">@DUWIAAW.</span>
            </p>
        </div>
    </footer>
    <!-- Akhir Footer -->



    <!-- JS Bootstarp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


</body>

</html>
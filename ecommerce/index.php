<?php
include "connection.php";
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "Connessione fallita: " . mysqli_connect_error();
}
$query = "USE ecommerce;";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">The future of furniture</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Fox's furniture</h1>
                <p class="lead fw-normal text-white-50 mb-0">poltrone e sofà, informatici di qualità</p>
            </div>
        </div>
    </header>
    <!-- SEZIONE DEI PRODOTTI-->
    <section class="py-5">

        <!--CATEGORIA PRODOTTI-->
        <form action="" method="GET" name="form-categoria">
            <select class="form-select" name="categoria" onchange="submit();">
                <option hidden>categoria</option>
                <option value="Tutti">Tutti</option>

                <?php
                $query = 'SELECT categorieprodotti.id_categoria, categorieprodotti.nome, categorieprodotti.descrizione FROM categorieprodotti';
                $result = mysqli_query($conn, $query);

                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<option value="' . $row["id_categoria"] . '">' . $row["nome"] . '</option>';
                    }
                } else {
                    echo 'Nessun dato presente';

                }

                ?>
            </select>
        </form>
      
        <!-- CONTENITORE DEI PRODOTTI-->
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">




                <!-- INIZIO PRODOTTI-->

                <?php
                //stampa di tutti i prodotti del database della categoria scelta, se si seleziona Tutti, stamperà tutti i prodotti
                
                if (isset($_GET['categoria'])) {
                    if($_GET['categoria']!="Tutti")
                        $query = "SELECT prodotti.nome, prodotti.prezzo, prodotti.peso, prodotti.descrizione, prodotti.immagine, prodotti.stock
                                    FROM prodotti
                                    WHERE prodotti.categoria=".$_GET['categoria'].";";
                    else
                        $query = "SELECT prodotti.nome, prodotti.prezzo, prodotti.peso, prodotti.descrizione, prodotti.immagine, prodotti.stock
                                    FROM prodotti;";
                    $result = mysqli_query($conn, $query);
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<div class="col mb-5">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top" src="'. $row["immagine"] .'" alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder">' . $row["nome"] . '</h5>
                                            <!-- Product reviews-->
                                            <div class="d-flex justify-content-center small text-warning mb-2">
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                            </div>
                                            <!-- Product price-->
                                            ' . $row["prezzo"] . '
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        echo "Nessun dato presente";
                    }
                }

                ?>


                <!---------------------------->
            </div>
        </div>
    </section>




    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
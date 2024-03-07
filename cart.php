<?php
ob_start();
session_start();
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
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
            <p class="navbar-brand" href="#!">The future of furniture</p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="ecommerce.php">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
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

                <form action="index.php">
                    <button class="btn btn-outline-dark" type="submit">
                        <h7>Logout</h7>
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


    <section class="h-100" style="background-color: #eee;">
        <div class="container h-100 py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-10">


                    <!--CARRELLO-->

                    <?php
                    $prezzoTotale = 0;
                    $query = "SELECT id_prodotto, quantita FROM ordini WHERE ordini.id_customer=".$_SESSION['cliente']."";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $id_prodotto_array = array();

                        while ($row = mysqli_fetch_assoc($result)) {
                            $id_prodotto_array[] = $row['id_prodotto'];
                            $quantita_prodotto[] = $row['quantita'];
                        }

                        foreach ($id_prodotto_array as $prodottoDaAcquistare) {

                            $query = 'SELECT prodotti.id_prodotto, prodotti.nome, prodotti.prezzo, prodotti.peso, prodotti.descrizione, prodotti.immagine, prodotti.categoria, prodotti.stock FROM prodotti WHERE prodotti.id_prodotto="' . $prodottoDaAcquistare . '"';

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_array($result);


                            echo '<div class="card rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                            <img src="' . $row['immagine'] . '"
                                                class="img-fluid rounded-3" alt="Cotton T-shirt">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <p class="lead fw-normal mb-2">Basic T-shirt</p>
                                            <p>Color: Default</p>
                                            <p>Quantity: '.$quantita_prodotto[array_search($prodottoDaAcquistare, $id_prodotto_array)] .' </p>
                                        </div>
                                        
                                            
                                        
                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                            <h5 class="mb-0">' . $row['prezzo']*$quantita_prodotto[array_search($prodottoDaAcquistare, $id_prodotto_array)] . '€</h5>
                                            <form action="" method="POST">
                                            <button style="border:none;background-color:transparent;color:red;font-size:30px; float:right;" value="' . $row['id_prodotto'] . '" name="cancellaOrdine">x</button>
                                        </form>
                                        </div>
                                        
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                            <a href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            $prezzoTotale+=$row['prezzo']*$quantita_prodotto[array_search($prodottoDaAcquistare, $id_prodotto_array)];
                        }

                    }

                    

                    ?>

                    <!------------------------------------>

                    <?php
                    //CANCELLA ORDINE DAL DB
                    if (isset($_POST['cancellaOrdine'])) {
                        $query = "DELETE FROM ordini WHERE ordini.id_prodotto=" . $_POST['cancellaOrdine'] . "";
                        mysqli_query($conn, $query);
                        header("Refresh:0");
                    }

                    $query = "SELECT * FROM ordini;";
                    $result = mysqli_query($conn, $query);

                    if ($result->num_rows > 0)
                        echo '<div class="card">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <button onclick="submit();" name="acquista"
                                        style="border: 1px solid yellow;border-radius:10px;padding:10px;background-color:yellow;font-size:20px;">Proceed
                                        to Pay</button>
                                </form><h2 style="float:right; margin-right:200px;">Totale: ';
                    echo $prezzoTotale . "€";
                    echo '</h2>';



                    if (isset($_POST['acquista'])) {
                        $query = "TRUNCATE TABLE ordini";
                        mysqli_query($conn, $query);
                        header("Location: ordine.php");
                        exit;
                    }

                    ?>

                </div>
            </div>

        </div>
        </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Fox's furniture 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
</body>

</html>
<?php
ob_end_flush();
?>
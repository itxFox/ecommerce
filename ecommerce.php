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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Fox'shop</title>
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
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
                <form class="d-flex">
                    <?php
                    if ($_SESSION['amministratore'] == 0) {
                        echo '
                            <a class="btn btn-outline-dark" href="cart.php">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">';

                        $query = "SELECT COUNT(id_prodotto) AS num_prodotto FROM ordini"; // Utilizza un alias per il risultato
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);

                        echo $row['num_prodotto'] . '</span>
                            </a>';
                    }
                    ?>

                    &nbsp;&nbsp;&nbsp;
                </form>
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
    <!-- SEZIONE DEI PRODOTTI-->
    <section class="py-5">

        <!--CATEGORIA PRODOTTI-->
        <form action="" method="GET" name="form-categoria">
            <select class="form-select" name="categoria" onchange="submit();" required>
                <option hidden>categoria</option>
                <option value="Tutti">Tutti</option>

                <?php
                $query = 'SELECT categorieprodotti.id_categoria, categorieprodotti.nome, categorieprodotti.descrizione FROM categorieprodotti';
                $result = mysqli_query($conn, $query);

                $categorie = array();

                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $categorie[] = $row["nome"];
                        echo '<option value="' . $row["id_categoria"] . '">' . $row["nome"] . '</option>';
                    }
                } else {
                    echo 'Nessun dato presente';

                }
                ?>

            </select>
        </form>

        <!--BOTTONE AGGIUNZIONE PRODOTTO-->
        <?php
            
        if (isset($_SESSION['amministratore']) && $_SESSION['amministratore'] == 1)
            echo '<form action="" method="GET" id="formInserimentoProdotto">
            <button type="submit" name="cliccato">+</button></form>';


        echo '<div id="divFormAggiungi">';
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cliccato'])) {
            echo '<div style="text-align: center;background-color: #1e2125;float:left;width:260px;padding:10px;border:1x solid black;border-radius:10px;margin-top:20px;margin-left:20px;">
            <form action="" id="formInserimentoProdotto2" method="POST" enctype="multipart/form-data">
            <div id="divFormInserimentoProdotto">
                <h4 style="color:white;">Inserisci un prodotto</h4>
                <input type="text" placeholder="nome" name="nomeProdotto" id="nomeProdotto" style="margin-bottom:3px;border-radius:10px;padding:3px;" required><br>
                <input type="number" placeholder="prezzo" name="prezzoProdotto" id="prezzoProdotto" step="0.01" style="margin-bottom:3px;border-radius:10px;padding:3px;" required><br>
                <input type="number" placeholder="peso" name="pesoProdotto" id="pesoProdotto" step="0.01" style="margin-bottom:3px;border-radius:10px;padding:3px;" required><br>
                <input type="text" placeholder="descrizione" name="descrizioneProdotto" id="descrizioneProdotto" style="margin-bottom:3px;border-radius:10px;padding:3px;" required><br>
                <input type="file" name="immagineProdotto" id="immagineProdotto" accept="image/*" style="color:white;"><br>
                <select name="categoriaProdotto" id="categoriaProdotto" style="margin-bottom:3px;border-radius:10px;padding:3px;width: 200px;">
                ';
            echo '<option hidden>categoria</option>';
            foreach ($categorie as $categoria)
                echo '<option value=' . $categoria . '>' . $categoria . '</option>';

            echo '</select><br>
                <input type="number" placeholder="stock" name="stockProdotto" id="stockProdotto" required style="margin-bottom:3px;border-radius:10px;padding:3px;"><br>
                <button type="submit" name="nuovoProdotto" style="margin-bottom:3px;border-radius:10px;padding:3px;border-color:green;color:green;">Inserisci</button>
                <button onclick="closeForm();" style="margin-bottom:3px;border-radius:10px;padding:3px;border-color:red;color:red;">Annulla</button>
            </div>
            </form></div>';
        }
        echo '</div>';
        ?>

        <script>
            function closeForm() {
                document.getElementById('divFormAggiungi').remove();
                document.getElementById('divFormInserimentoProdotto').remove();
            }
        </script>




        <!--INSERIMENTO DI UN PRODOTTO-->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuovoProdotto']) && $_SESSION['amministratore'] == 1) {
            $conn = mysqli_connect($hostname, $username, $password, $dbname);

            if (!$conn) {
                die("Connessione al database fallita: " . mysqli_connect_error());
            }

            $upload_dir = "furniture/";

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (!is_writable($upload_dir)) {
                echo "La directory di upload non ha i permessi di scrittura necessari.";
                exit;
            }

            $target_file = $upload_dir . basename($_FILES["immagineProdotto"]["name"]);

            $queryCheck = 'SELECT * FROM prodotti WHERE nome="' . $_POST['nomeProdotto'] . '" AND prezzo=' . $_POST['prezzoProdotto'] . ' AND descrizione="' . $_POST['descrizioneProdotto'] . '"';
            $resultCheck = mysqli_query($conn, $queryCheck);

            if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            } else {
                if (move_uploaded_file($_FILES["immagineProdotto"]["tmp_name"], $target_file)) {
                    $queryCategoria = 'SELECT categorieprodotti.id_categoria FROM categorieprodotti WHERE categorieprodotti.nome="' . $_POST['categoriaProdotto'] . '";';
                    $resultCategoria = mysqli_query($conn, $queryCategoria);

                    if ($resultCategoria && mysqli_num_rows($resultCategoria) > 0) {
                        $row = mysqli_fetch_assoc($resultCategoria);
                        $idCategoria = $row['id_categoria'];

                        $query = 'INSERT INTO prodotti (nome, prezzo, peso, descrizione, immagine, categoria, stock)
                            VALUES("' . $_POST['nomeProdotto'] . '", ' . $_POST['prezzoProdotto'] . ', ' . $_POST['pesoProdotto'] . ', "' . $_POST['descrizioneProdotto'] . '", "' . $target_file . '", ' . $idCategoria . ', ' . $_POST['stockProdotto'] . ');';
                        $result = mysqli_query($conn, $query);

                        $query = 'SELECT prodotti.id_prodotto FROM prodotti
                        WHERE prodotti.nome="' . $_POST['nomeProdotto'] . '" AND
                                prodotti.prezzo=' . $_POST['prezzoProdotto'] . ' AND
                                prodotti.peso=' . $_POST['pesoProdotto'] . ' AND
                                prodotti.descrizione="' . $_POST['descrizioneProdotto'] . '" AND
                                prodotti.immagine="' . $target_file . '" AND
                                prodotti.categoria=' . $idCategoria . ' AND
                                prodotti.stock=' . $_POST['stockProdotto'] . '';

                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        $idProdotto = $row['id_prodotto'];

                        $query = 'INSERT INTO prodotti_categorie (id_prodotto, id_categoria)
                            VALUES (' . $idProdotto . ',' . $idCategoria . ');';

                        mysqli_query($conn, $query);
                    }
                }
            }
        }


        ?>



        <!-- CONTENITORE DEI PRODOTTI-->
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">




                <!-- INIZIO PRODOTTI-->

                <?php
                //stampa di tutti i prodotti del database della categoria scelta, se si seleziona Tutti, stamperà tutti i prodotti
                


                if (isset($_GET['categoria']) && $_GET['categoria'] != "Tutti")
                    $query = "SELECT prodotti.id_prodotto, prodotti.nome, prodotti.prezzo, prodotti.peso, prodotti.descrizione, prodotti.immagine, prodotti.stock
                                    FROM prodotti
                                    WHERE prodotti.categoria=" . $_GET['categoria'] . ";";
                else
                    $query = "SELECT prodotti.id_prodotto, prodotti.nome, prodotti.prezzo, prodotti.peso, prodotti.descrizione, prodotti.immagine, prodotti.stock
                                    FROM prodotti;";
                $result = mysqli_query($conn, $query);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<div class="col mb-5">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top" src="' . $row["immagine"] . '" alt="..." />
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
                                        <div class="text-center">';
                        if ($_SESSION['amministratore'] == 0) {
                            echo '
                                            <form action="" method="POST">
                                                <button type="submit" class="btn btn-outline-dark mt-auto" name="aggiungiAlCarrello" value="' . $row["id_prodotto"] . '">Add to cart</button><br></br>
                                            </form>';
                        }

                        if (isset($_POST['aggiungiAlCarrello'])) {
                            $query = "INSERT INTO ordini(id_prodotto)
                            VALUES(" . $_POST['aggiungiAlCarrello'] . ")";
                            mysqli_query($conn, $query);

                            $query = "DELETE FROM ordini
                            WHERE id_ordine NOT IN (
                                SELECT MIN(id_ordine)
                                FROM ordini
                                GROUP BY id_prodotto
                            );";
                            mysqli_query($conn, $query);
                        }




                        if (isset($_SESSION['amministratore']) && $_SESSION['amministratore'] == 1) {
                            echo '
                                                <form action="" method="POST">
                                                    <button onclick="submit();" style="color:red;font-size:20px;border-color:red;" name="bottoneEliminaProdotto" value="' . $row["id_prodotto"] . '">Elimina</button>
                                                </form>';
                        }

                        echo '
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    echo "Nessun dato presente";
                }

                //ELIMINAZIONE PRODOTTO DAL DATABASE
                
                if (isset($_POST['bottoneEliminaProdotto'])) {

                    ////////ELIMINA PRODOTTI_CATEGORIE
                    $query = "SELECT prodotti_categorie.id_categoria FROM prodotti_categorie
                    where prodotti_categorie.id_prodotto=" . $_POST['bottoneEliminaProdotto'] . ";";

                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo "categoria:" . $row['id_categoria'];

                    $query = "DELETE FROM prodotti_categorie WHERE prodotti_categorie.id_prodotto = " . $_POST['bottoneEliminaProdotto'] . " AND  prodotti_categorie.id_categoria=" . $row['id_categoria'] . ";";
                    $result = mysqli_query($conn, $query);
                    ////////////////////////////////
                
                    /////ELIMINA IMMAGINE
                    $query = "SELECT prodotti.immagine FROM prodotti WHERE prodotti.id_prodotto = " . $_POST['bottoneEliminaProdotto'] . ";";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $dirImmagineDaEliminare = $row['immagine'];

                        if (file_exists($dirImmagineDaEliminare)) {
                            unlink($dirImmagineDaEliminare);
                        }
                    }
                    ////////////////////
                
                    ///////ELIMINA PRODOTTO
                    $query = "DELETE FROM prodotti WHERE prodotti.id_prodotto = " . $_POST['bottoneEliminaProdotto'] . ";";
                    $result = mysqli_query($conn, $query);
                    //////////////////////
                
                    header("Refresh:0");
                }
                ?>


                <!---------------------------->
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
    <script src="js/scripts.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>
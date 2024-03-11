<?php
// Avvia la sessione PHP
session_start();
// Avvia l'output buffering
ob_start();

// Includi il file di connessione al database
include "connection.php";
// Connettiti al database
$conn = mysqli_connect($hostname, $username, $password, $dbname);
// Verifica se la connessione al database ha avuto successo
if (mysqli_connect_errno()) {
    echo "Connessione fallita: " . mysqli_connect_error();
}

// Imposta il database su cui eseguire le query
$query = "USE ecommerce;";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Includi i fogli di stile -->
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Includi gli script JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <script>
        function validateForm() {
            var email = document.getElementById("typeEmailX").value;
            var password = document.getElementById("typePasswordX").value;
            var name = document.getElementById("typeNameX").value;
            var address = document.getElementById("typeIndirizzoX").value;
            var city = document.getElementById("typeCittaX").value;
            var phone = document.getElementById("typeNumeroX").value;
            var confirmPass = document.getElementById("typePasswordXConferma").value;

            // Controllo dell'email
            var emailRegex = /\S+@\S+\.\S+/;
            if (!emailRegex.test(email)) {
                alert("Inserisci un'email valida.");
                return false;
            }

            // Controllo della password
            if (password.length < 6) {
                alert("La password deve essere lunga almeno 6 caratteri.");
                return false;
            }

            // Controllo della conferma della password
            if (password !== confirmPass) {
                alert("La password e la conferma della password non corrispondono.");
                return false;
            }

            // Controllo del nome
            if (name.trim() === "") {
                alert("Inserisci il tuo nome.");
                return false;
            }

            // Controllo dell'indirizzo
            if (address.trim() === "") {
                alert("Inserisci il tuo indirizzo.");
                return false;
            }

            // Controllo della città
            if (city.trim() === "") {
                alert("Inserisci la tua città.");
                return false;
            }

            // Controllo del numero di telefono
            var phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(phone)) {
                alert("Inserisci un numero di telefono valido (10 cifre senza spazi o simboli).");
                return false;
            }

            return true; // Tutti i controlli passati
        }
    </script>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <form action="" method="POST" onsubmit="return validateForm();">
                                    <?php
                                    // Verifica se il modulo di registrazione è stato inviato
                                    if (isset($_POST['registrati']))
                                        echo '<h2 class="fw-bold mb-2 text-uppercase">Registrati</h2>';
                                    else
                                        echo '<h2 class="fw-bold mb-2 text-uppercase">Accedi</h2>';
                                    ?>
                                    <br><br><br>
                                    <?php
                                    // Verifica se il modulo di registrazione è stato inviato
                                    if (isset($_POST['registrati']))
                                        echo '<div>
                                                <input type="email" id="typeEmailX" name="typeEmailX" placeholder="email" class="inputbox" required/>
                                                <input type="password" id="typePasswordX" name="typePasswordX" placeholder="password" class="inputbox" required/>
                                                <br>
                                                <input type="text" id="typeNameX" name="typeNameX" placeholder="nome" class="inputbox" required/>
                                                <input type="indirizzo" id="typeIndirizzoX" name="typeIndirizzoX" placeholder="indirizzo" class="inputbox" required/>
                                                <br>
                                                <input type="text" id="typeCittaX" name="typeCittaX" placeholder="città" class="inputbox" required/>
                                                <input type="text" class="inputbox" id="typeNumeroX" name="typeNumeroX" placeholder="telefono" required />
                                                <br>
                                                <input type="password" id="typePasswordXConferma" name="typePasswordXConferma" placeholder="conferma password" class="inputbox"required />
                                                </div>';
                                    else
                                        echo '<div class="form-outline form-white mb-4">
                                                <input type="email" id="typeEmailX" name="typeEmailX"
                                                    class="form-control form-control-lg" required/>
                                                <label class="form-label" for="typeEmailX">Email</label>
                                            </div>

                                            <div class="form-outline form-white mb-4">
                                                <input type="password" id="typePasswordX" name="typePasswordX"
                                                    class="form-control form-control-lg" required/>
                                                <label class="form-label" for="typePasswordX">Password</label>
                                            </div>';
                                    ?>

                                    <?php
                                    // Mostra il pulsante di login o di registrazione a seconda della condizione
                                    if (!isset($_POST['registrati']))
                                        echo '<button class="btn btn-outline-light btn-lg px-5" type="submit" id="loginButton" name="loginButton">Entra</button>';
                                    else
                                        echo '<button class="btn btn-outline-light btn-lg px-5" type="submit" id="signinButton" name="signinButton">Registra</button>';
                                    ?>

                                </form>
                                <?php
                                // Gestione del login e della registrazione
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                    if (isset($_POST['loginButton'])) {
                                        // Esegui il login se le credenziali sono corrette
                                        // Query per verificare le credenziali
                                        $query = 'SELECT clienti.id_customer, clienti.email, clienti.passw, clienti.amministratore, clienti.nome FROM clienti WHERE email=?';
                                        $stmt = mysqli_prepare($conn, $query);
                                        mysqli_stmt_bind_param($stmt, "s", $_POST['typeEmailX']);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);

                                            // Verifica se la password inserita corrisponde all'hash salvato nel database
                                            if (password_verify($_POST['typePasswordX'], $row['passw'])) {
                                                $_SESSION['amministratore'] = $row['amministratore'];
                                                $_SESSION['cliente'] = $row['id_customer'];
                                                $_SESSION['nome'] = $row['nome'];
                                                header("Location: index.php");
                                                exit();
                                            } else {
                                                echo "Credenziali non valide";
                                            }
                                        } else {
                                            echo "Account non trovato";
                                        }
                                    } else if (isset($_POST['signinButton'])) {
                                        // Esegui una query per verificare se l'email esiste già
                                        $query = 'SELECT * FROM clienti WHERE email=?';
                                        $stmt = mysqli_prepare($conn, $query);
                                        mysqli_stmt_bind_param($stmt, "s", $_POST['typeEmailX']);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        // Esegui la registrazione se l'email non esiste già
                                        if (mysqli_num_rows($result) == 0) {
                                            // Utilizza un'istruzione preparata per inserire i dati
                                            $query = "INSERT INTO clienti(email, passw, nome, indirizzo, citta, telefono) VALUES(?, ?, ?, ?, ?, ?)";
                                            $stmt = mysqli_prepare($conn, $query);

                                            // Combina la password con il salt
                                            $hashedPassword = password_hash($_POST['typePasswordX'], PASSWORD_DEFAULT);

                                            // Associa i valori alle posizioni dei parametri
                                            mysqli_stmt_bind_param($stmt, "ssssss", $_POST['typeEmailX'], $hashedPassword, $_POST['typeNameX'], $_POST['typeIndirizzoX'], $_POST['typeCittaX'], $_POST['typeNumeroX']);
                                            // Esegui la query preparata
                                            mysqli_stmt_execute($stmt);

                                            // Recupera l'ID cliente appena inserito
                                            $newCustomerId = mysqli_insert_id($conn);

                                            // Se necessario, esegui altre operazioni dopo l'inserimento
                                            // ...
                                
                                            // Chiudi lo statement
                                            mysqli_stmt_close($stmt);

                                            // Esegui una query per recuperare i dati appena inseriti
                                            $query = 'SELECT id_customer, amministratore FROM clienti WHERE id_customer=?';
                                            $stmt = mysqli_prepare($conn, $query);
                                            mysqli_stmt_bind_param($stmt, "i", $newCustomerId);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            $row = mysqli_fetch_assoc($result);
                                            $_SESSION['amministratore'] = $row['amministratore'];
                                            $_SESSION['cliente'] = $row['id_customer'];

                                            echo '<script>alert("Signed in as ' . $_POST['typeNameX'] . '");</script>';
                                            header("Refresh:0");
                                            exit();
                                        } else {
                                            echo '<script>window.alert("Email già esistente!");</script>';
                                        }

                                    } else if (isset($_POST['guest'])) {
                                        session_destroy();
                                        
                                        header("Location: index.php");
                                        exit();
                                    }
                                }
                                ?>


                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>

                            </div>

                            <form action="" method="POST">
                                <?php
                                // Mostra il link per il login o la registrazione a seconda della condizione
                                if (isset($_POST['registrati']))
                                    echo '<p class="mb-0">Hai un account?
                                        <button class="custom-button"
                                            onclick="submit();">Accedi</button>
                                    </p>';
                                else
                                    echo '<p class="mb-0">Non hai un account?
                                        <button class="custom-button" name="registrati"
                                            onclick="submit();">Registrati</button>
                                        </p><br>
                                        <p>Oppure entra come <button class="custom-button" name="guest"
                                        onclick="submit();">Guest</button></p';
                                ?>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

<?php
// Termina l'output buffering e invia l'output al client
ob_end_flush();
?>

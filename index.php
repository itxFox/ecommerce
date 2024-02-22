<?php
session_start();
ob_start(); // Avvia l'output buffering

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
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">


                                <form action="" method="POST">
                                    <?php 
                                        if (isset($_POST['registrati'])) echo'<h2 class="fw-bold mb-2 text-uppercase">Registrati</h2>';
                                        else echo'<h2 class="fw-bold mb-2 text-uppercase">Accedi</h2>';
                                    ?>
                                    <br><br><br>
                                    <?php
                                    if (isset($_POST['registrati']))
                                        echo '<div>
                                                <input type="email" id="typeEmailX" name="typeEmailX" placeholder="email" class="inputbox" />
                                                <input type="password" id="typePasswordX" name="typePasswordX" placeholder="password" class="inputbox" />
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
                                                    class="form-control form-control-lg" />
                                                <label class="form-label" for="typeEmailX">Email</label>
                                            </div>

                                            <div class="form-outline form-white mb-4">
                                                <input type="password" id="typePasswordX" name="typePasswordX"
                                                    class="form-control form-control-lg" />
                                                <label class="form-label" for="typePasswordX">Password</label>
                                            </div>';
                                    ?>

                                    <?php 
                                        if (!isset($_POST['registrati']))
                                            echo'<button class="btn btn-outline-light btn-lg px-5" type="submit" id="loginButton" name="loginButton"
                                            disabled>Entra</button>';
                                        else
                                        echo'<button class="btn btn-outline-light btn-lg px-5" type="submit" id="signinButton" name="v"
                                            disabled>Registra</button>';
                                    ?>
                                    
                                </form>
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
                                    if (isset($_POST['typeEmailX']) && isset($_POST['typePasswordX'])) {
                                        $query = 'SELECT clienti.email, clienti.passw, clienti.amministratore
                                                    FROM clienti
                                                    WHERE clienti.email="' . $_POST['typeEmailX'] . '" AND clienti.passw="' . $_POST['typePasswordX'] . '";';

                                        $result = mysqli_query($conn, $query);

                                        if ($result->num_rows > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $_SESSION['amministratore'] = $row['amministratore'];
                                            header("Location: ecommerce.php");
                                            exit();
                                        } else {
                                            // Utente non trovato, puoi aggiungere un messaggio o una logica aggiuntiva qui
                                            echo "account non trovato";
                                        }
                                    }
                                }

                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signinButton'])){
                                    echo'porco dio';
                                }

                                ?>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const emailInput = document.getElementById('typeEmailX');
                                        const passwlInput = document.getElementById('typePasswordX');
                                        const loginButton = document.getElementById('loginButton');
                                        const signinButton = document.getElementById('signinButton');
                                        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

                                        emailInput.addEventListener('input', function () {
                                            if (emailRegex.test(emailInput.value) && passwlInput.value.length >= 5) {
                                                loginButton.removeAttribute('disabled');
                                                signinButton.removeAttribute('disabled');
                                                
                                            } else {
                                                loginButton.setAttribute('disabled', 'true');
                                                signinButton.setAttribute('disabled', 'true');
                                            }
                                        });

                                        passwlInput.addEventListener('input', function () {
                                            if (emailRegex.test(emailInput.value) && passwlInput.value.length >= 5) {
                                                loginButton.removeAttribute('disabled');
                                                signinButton.removeAttribute('disabled');
                                            } else {
                                                loginButton.setAttribute('disabled', 'true');
                                                signinButton.setAttribute('disabled', 'true');
                                            }
                                        });
                                    });
                                </script>


                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>

                            </div>
                                
                            <form action="" method="POST">
                                <?php 
                                    if (isset($_POST['registrati']))
                                        echo'<p class="mb-0">Hai un account?
                                        <button class="custom-button"
                                            onclick="submit();">Accedi</button>
                                    </p>';
                                    else
                                        echo'<p class="mb-0">Non hai un account?
                                        <button class="custom-button" name="registrati"
                                            onclick="submit();">Registrati</button>
                                        </p>';
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
ob_end_flush();
?>
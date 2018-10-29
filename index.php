<?php
    $errorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['emailadres']) && isset($_POST['wachtwoord'])){


            $email = $_POST['emailadres'];
            $wachtwoord = $_POST['wachtwoord'];

            $sql3 = "SELECT wachtwoord FROM gebruiker WHERE emailadres = '$email'";
            $result1 = mysqli_query($conn, $sql3);
            $row1 = mysqli_fetch_assoc($result1);

            $hash = $row1['wachtwoord'];

            if(password_verify($wachtwoord, $hash)){

                $sql= "SELECT * FROM gebruiker WHERE emailadres = '$email' AND wachtwoord = '$hash'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $voornaam = $row['voornaam'];
                $achternaam = $row['achternaam'];

                if(mysqli_num_rows($result) == 1){
                    $_SESSION['logged_in'] = TRUE; // <-- To check on other pages if user is logged in
                    header('location: ../index.php'); // <-- Redirect to next page
                }
                else{
                    $errorMessage = "Email or password is incorrect";
                }
            }
            else{
                $errorMessage = "Email or password is incorrect";
            }
        }
        else {
            $errorMessage = "Something went wrong";
        }
    }
?>
<div class="row content-container">
   <div class="col-md-4 float-none align-center login-container fade-in">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="header-login"><h2>Log in met je Macho account!</h2></div>
            <input type="email" name="emailadres" placeholder="Emailadres..." required />
            <input type="password" name="wachtwoord" placeholder="Wachtwoord..." required />
            <button type="submit">Log in</button>
            <p style="color:red; float:left;"><?php echo $errorMessage; ?></p>
            <a href="forgot-password.php" style="float:right;">Wachtwoord vergeten?</a>
        </form>
   </div>
</div>

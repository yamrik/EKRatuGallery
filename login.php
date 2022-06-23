<?php 

require_once("code/config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // bind parameter ke query
    $params = array(
        ":username" => $username
    );
    
    $sql = "SELECT * FROM user WHERE username=:username";
    $stmt = $db->prepare($sql);

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["password"])){
            // buat Session
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman timeline
            if($username=="admin") header("Location: admin.php");
            else {
                echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Anda Berhasil Login');
                    window.location.href='index.php';
                </script>");
            }
        }
        else{echo("<script LANGUAGE='JavaScript'>
            window.alert('Maaf Password Anda Salah');
            window.location.href='login.php';
        </script>");
        };
    }
    else{ echo("<script LANGUAGE='JavaScript'>
        window.alert('Maaf Username anda salah');
        window.location.href='login.php';
    </script>");};
}
?>

<html lang="en">
<?php require_once "theme/head.php";?>
    <body>
        <!-- Navigation-->
        <?php
            require_once "theme/navig.php";
        ?>
        <!-- Header-->
        <?php require_once "theme/header.php";?>
        <!-- Section-->
        <section class="py-5">
            <main class="form-signin" style="width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
  font-weight: 400;z-index: 2;">
            <form action="" method="POST">
                <h1 class="h3 mb-3 fw-normal">Silahkan login</h1>

                <div class="form-floating">
                    <input type="username" class="form-control" id="floatingInput" name="username" placeholder="Username">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="login" value="Login">Login</button>
            </form>
        </main>
        </section>
        <!-- Footer-->
        <?php 
            require_once "theme/footer.php"; 
        ?>
    </body>
</html>
<?php
if(!empty($_SESSION['id'])){
    header("Location:" . ROOT . "home");
}

include("classes/login.php");

$usernameErr = $passwordErr = "";
$username = $password = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new Login();
    if ($login->attempt()) {
        header("Location:" . ROOT . "home");
        die;
    } else {
        $username = $login->oldInputs['username'] ?? '';
        $password = $login->oldInputs['password'] ?? '';
        $usernameErr = $login->errors['username'] ?? '';
        $passwordErr = $login->errors['password'] ?? '';
    }
}
?>

<div class="row justify-content-center">
    <div class="col col-md-6">
        <div class="card p-5 m-auto mt-5">
            <h3 class="card-title text-center">
                <a href="home" class="text-decoration-none">CRM</a>
            </h3>
            <form method="post" action="">
                <div class="mb-3 mt-3">
                    <label class="form-label text-capitalize">username:</label>
                    <input class="form-control <?= $usernameErr ? 'is-invalid' : '' ?>" type="text" name="username" autocomplete="off" value="<?= $username ?>">
                    <div class="invalid-feedback"><?= $usernameErr ?></div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-capitalize">password:</label>
                    <input class="form-control <?= $passwordErr ? 'is-invalid' : '' ?>" type="text" name="password" autocomplete="off" value="<?= $password ?>">
                    <div class="invalid-feedback"><?= $passwordErr ?></div>
                </div>
                <div class="alert alert-danger mt-2 d-none" role="alert"></div>
                <div class="d-flex justify-content-between mt-5">
                    <a href="register" class="text-capitalize">Create Account</a>
                    <button class="btn btn-primary text-capitalize">login</button>
                </div>
            </form>
        </div>
    </div>
</div>
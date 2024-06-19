<?php
if(!empty($_SESSION['id'])){
    header("Location:" . ROOT . "home");
}

include("classes/register.php");

$emailErr = $usernameErr = $passwordErr = "";
$email = $username = $password = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $register = new Register();
    if ($register->save()) {
        header("Location:" . ROOT . "home");
        die;
    } else {
        $email = $register->oldInputs['email'] ?? '';
        $username = $register->oldInputs['username'] ?? '';
        $password = $register->oldInputs['password'] ?? '';
        $emailErr = $register->errors['email'] ?? '';
        $usernameErr = $register->errors['username'] ?? '';
        $passwordErr = $register->errors['password'] ?? '';
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
                    <label class="form-label text-capitalize">email:</label>
                    <input class="form-control <?= $emailErr ? 'is-invalid' : '' ?>" type="text" name="email" autocomplete="off" value="<?= $email ?>">
                    <div class="invalid-feedback"><?= $emailErr ?></div>
                </div>
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
                <div class="d-flex justify-content-end mt-5">
                    <button class="btn btn-primary text-capitalize">register</button>
                </div>
            </form>
        </div>
    </div>
</div>
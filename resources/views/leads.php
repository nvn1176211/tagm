<?php
if (empty($_SESSION['id'])) {
    header("Location:" . ROOT . "login");
}

include("classes/leads.php");

$emailErr = $nameErr = $phoneErr = "";
$email = $name = $phone = "";
$lead = new leads();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // echo '<pre>';var_dump($url);echo '</pre>';die;
    if(!empty($url[2]) && $url[2] == 'delete'){
        $result = $lead->delete($url[1]);
        if($result){
            header("Location:" . ROOT . "leads");
            die;
        }
    }elseif ($lead->create()) {
        header("Location:" . ROOT . "leads");
        die;
    } else {
        $email = $lead->oldInputs['email'] ?? '';
        $name = $lead->oldInputs['name'] ?? '';
        $phone = $lead->oldInputs['phone'] ?? '';
        $emailErr = $lead->errors['email'] ?? '';
        $nameErr = $lead->errors['name'] ?? '';
        $phoneErr = $lead->errors['phone'] ?? '';
    }
}
$leadList = $lead->get();
?>

<h2 class="text-capitalize">leads</h2>
<div class="mb-5">
    <form method="post" action="">
        <div class="mb-3 mt-3">
            <label class="form-label text-capitalize">name:</label>
            <input class="form-control <?= $nameErr ? 'is-invalid' : '' ?>" type="text" name="name" autocomplete="off" value="<?= $name ?>">
            <div class="invalid-feedback"><?= $nameErr ?></div>
        </div>
        <div class="mt-3">
            <label class="form-label text-capitalize">phone:</label>
            <input class="form-control <?= $phoneErr ? 'is-invalid' : '' ?>" type="text" name="phone" autocomplete="off" value="<?= $phone ?>">
            <div class="invalid-feedback"><?= $phoneErr ?></div>
        </div>
        <div class="mb-3 mt-3">
            <label class="form-label text-capitalize">email:</label>
            <input class="form-control <?= $emailErr ? 'is-invalid' : '' ?>" type="text" name="email" autocomplete="off" value="<?= $email ?>">
            <div class="invalid-feedback"><?= $emailErr ?></div>
        </div>
        <div class="alert alert-danger mt-2 d-none" role="alert"></div>
        <div class="d-flex justify-content-end mt-5">
            <button class="btn btn-primary text-capitalize">create new lead</button>
        </div>
    </form>
</div>
<form method="post" action="" id="deleteForm">
</form>
<h3 class="text-capitalize">Lead list</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col" class="text-capitalize">name</th>
            <th scope="col" class="text-capitalize">phone</th>
            <th scope="col" class="text-capitalize">email</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($leadList as $index => $lead) : ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $lead['name'] ?></td>
                <td><?= $lead['phone'] ?></td>
                <td><?= $lead['email'] ?></td>
                <td class="text-center">
                    <a href="leads/<?= $lead['id'] ?>/edit" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger" onclick="submitDeleteForm('<?= ROOT . "leads/" . $lead["id"] . "/delete" ?>')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($leadList)) : ?>
            <tr>
                <td colspan="6">Empty</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
<script>
    function submitDeleteForm(url){
        let deleteForm = document.getElementById('deleteForm');
        deleteForm.setAttribute('action', url);
        deleteForm.submit();
    }
</script>
<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #accountDropdownMenu {
            width: 250px;
        }

        .switch-btn {
            width: 40px !important;
            height: 24px !important;
            margin: 0 !important;
        }
    </style>
</head>

<body>
    <nav class="border-bottom nav-bar zindex-fixed" id="myNav">
        <div class="ps-3 pe-3 position-relative">
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <a href="home" class="text-decoration-none">
                        <h1 class="m-0">CRM</h1>
                    </a>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-end align-items-center">
                    <a href="login" class="btn btn-primary rounded-pill text-capitalize me-2 <?php if(!empty($_SESSION['id'])) echo 'd-none'; ?>">login</a>
                    <div class="d-flex flex-column justify-content-center <?php if(empty($_SESSION['id'])) echo 'd-none'; ?>" id="header-user-info">
                        <div class="dropdown">
                            <i class="bi bi-person-circle fs-3" role="button" id="accountDropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"></i>
                            <ul class="dropdown-menu" id="accountDropdownMenu" aria-labelledby="accountDropdownMenuButton">
                                <li class="dropdown-item d-flex align-items-center" role="button" id="darkmodeSwitchRef" onclick="darkModeSwitch()">
                                    <i class="bi bi-moon fs-4 me-3"></i>
                                    <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                        <div class="text-capitalize">dark mode</div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-btn" type="checkbox" id="darkmodeSwitchBtn" role="button">
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item text-capitalize d-flex align-items-center" role="button" onclick="logout()">
                                    <i class="bi bi-box-arrow-right fs-4 me-3"></i>
                                    <span>logout</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script>
        function darkModeSwitch(){
            let html = document.documentElement;
            let darkmodeSwitchBtn = document.getElementById('darkmodeSwitchBtn');
            html.setAttribute('data-bs-theme', html.getAttribute('data-bs-theme') == 'dark' ? '' : 'dark');
            if(
                (html.getAttribute('data-bs-theme') == 'dark' && darkmodeSwitchBtn.checked != true)
                || (html.getAttribute('data-bs-theme') != 'dark' && darkmodeSwitchBtn.checked == true)
            ){
                darkmodeSwitchBtn.checked = darkmodeSwitchBtn.checked == true ? false : true;
            }
        }
        function logout(){
            location.href = '<?= ROOT . "logout" ?>';
        }
    </script>
    <div class="container">
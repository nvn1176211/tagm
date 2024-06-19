<?php
    $toastMsg = '';
    if(!empty($_SESSION['successMsg'])){
        $toastMsg = $_SESSION['successMsg'];
        unset($_SESSION['successMsg']);
    }
?>

    </div>
    <div class="position-fixed top-0 start-50 translate-middle-x p-3 zindex-tooltip">
		<div id="successToast" class="toast hide bg-success text-white" role="alert" aria-live="assertive"
			aria-atomic="true" data-bs-animation="true">
			<div class="toast-body d-flex justify-content-between align-items-center">
				<span><?= $toastMsg ?></span>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>
    <script>
        let toastMsg = '<?= $toastMsg ?>';
        let sucessToast = new bootstrap.Toast(document.getElementById('successToast'));
        if(toastMsg){
            sucessToast.show();
        }
    </script>
</body>
</html>
<?php 
    require_once('./db.php');
    $sql = 'SELECT * FROM users WHERE id = ?';
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        $user_id = 1;
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            echo '<pre>';
            print_r($row);
            echo '</pre>';
        }
    }else{
        echo 'failed';
    }
?>
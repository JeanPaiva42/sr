<?php

    session_start();

    setcookie('user_loged', '');
    setcookie('user_cod', '');
    setcookie('user_email', '');

    
    session_destroy();

    echo "<script>window.location='index.php'</script>";

?>

<?php
@session_start();

if(!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_usuario']) ){
    echo "<script>window.location='../index.php'</script>";
}
?>
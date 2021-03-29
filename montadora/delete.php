<?php  
	require("../_config/connection.php");

    $error = false;

    if(!$_GET || !$_GET["id"]){
        header('Location: index.php?message=Id da fabricante não informado!');
        die();
    }

    $fabricanteId = $_GET["id"];

    try {
        $query = "DELETE FROM fabricantes WHERE id=$fabricanteId";
		$result = $conn->query($query);
        $conn->close();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    $message = ($result && !$error) ? "fabricante excluida com sucesso." : "Erro ao excluir a fabricante.";
    header("Location: index.php?message=$message");
    die();


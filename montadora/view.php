<?php
require("../_config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Visualizar fabricante</title>
</head>

<?php
$fabricante = false;
$error = false;

if (!$_GET || !$_GET["id"]) {
    header('Location: index.php?message=Id da fabricante não informado!');
    die();
}

$fabricanteId = $_GET["id"];

try {
    $query = "SELECT * FROM fabricantes WHERE id=$fabricanteId";
    $result = $conn->query($query);
    $fabricante = $result->fetch_assoc();
    $result->close();
} catch (Exception $e) {
    $error = $e->getMessage();
}

if (!$fabricante || $error) {
    header('Location: index.php?message=Erro ao recuperar dados da fabricante!');
    die();
}

$conn->close();

?>

<body>

    <?php
        require("../_partials/navbar.php");
    ?>

    <section class="container mt-5 mb-5">
        <div class="row mb-3">
            <div class="col">
                <h1>Visualizar fabricante</h1>
            </div>
        </div>

        <div class="mb-3">
            <h3>Nome</h3>
            <p><?= $fabricante["nome"] ?></p>
        </div>

        <div class="mb-3">
            <h3>Origem</h3>
            <p><?= $fabricante["origem"] ?></p>
        </div>

    </section>
</body>

</html>
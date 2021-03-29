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
    <title>Visualizar produto</title>
</head>

<?php
$carro = false;
$error = false;

if (!$_GET || !isset($_GET["id"])) {
    header('Location: index.php?message=Id do produto não informado!');
    die();
}

$carro_id = $_GET["id"];

try {
    $query = "SELECT c.*, f.nome as fabricante 
        FROM carros c
        INNER JOIN fabricantes f on c.fabricante_id = f.id
        WHERE c.id=$carro_id";

    $result = $conn->query($query);
    $carro = $result->fetch_assoc();
    $result->close();
} catch (Exception $e) {
    $error = $e->getMessage();
}

if (!$carro || $error) {
    header('Location: index.php?message=Erro ao recuperar dados do produto!');
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
                <h1>Visualizar produto</h1>
            </div>
        </div>

        <div class="mb-3">
            <h3>Modelo</h3>
            <p><?= $carro["modelo"] ?></p>
        </div>

        <div class="mb-3">
            <h3>Categoria</h3>
            <p><?= $carro["categoria"] ?></p>
        </div>

        <div class="mb-3">
            <h3>Tipo de combustível</h3>
            <p><?= $carro["tipo_combustivel"] ?></p>
        </div>

    </section>
</body>

</html>
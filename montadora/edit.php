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
    <title>Editar fabricante</title>
</head>

<?php
$fabricante = false;
$error = false;

if (!$_GET || !isset($_GET["id"])) {
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

$upadeError = false;
$updateResult = false;
if ($_POST) {
    try {
        $name = $_POST["name"];
        $origin = $_POST["origin"];

        $query = "UPDATE fabricantes SET 
            nome='$name', 
            origem='$origin'
        WHERE 
            id=$fabricanteId
        ";

        $updateResult = $conn->query($query);

        if ($updateResult) {
            header('Location: index.php?message=fabricante alterada com sucesso!');
            die();
        }
    } catch (Exception $e) {
        $upadeError = $e->getMessage();
    }
}

$conn->close();

?>

<body>

    <?php
        require("../_partials/navbar.php");
    ?>

    <section class="container mt-5 mb-5">

        <?php if ($_POST && (!$updateResult || $upadeError)) : ?>
            <p>
                Erro ao alterar a fabricante.
                <?= $error ? $error : "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Editar fabricante</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome do produto" value="<?= $fabricante["nome"] ?>">
            </div>

            <div class="mb-3">
                <label for="origin" class="form-label">Origem</label>
                <textarea type="text" class="form-control" id="origin" name="origin"><?= $fabricante["origem"] ?></textarea>
            </div>

            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>
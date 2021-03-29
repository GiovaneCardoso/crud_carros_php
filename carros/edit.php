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
    <title>Editar carro</title>
</head>

<?php
$carro = false;
$error = false;

if (!$_GET || !isset($_GET["id"])) {
    header('Location: index.php?message=Id do carro não informado!');
    die();
}

$carroId = $_GET["id"];

try {
    $query = "SELECT * FROM carros WHERE id=$carroId";
    $result = $conn->query($query);
    $carro = $result->fetch_assoc();
    $result->close();
} catch (Exception $e) {
    $error = $e->getMessage();
}

if (!$carro || $error) {
    header('Location: index.php?message=Erro ao recuperar dados do carro!');
    die();
}

$upadeError = false;
$updateResult = false;
if ($_POST) {
    try {
        $modelo = $_POST["model"];
        $categoria = $_POST["category"];
        $type_fuel = $_POST["tipo_combustivel"];
        $fabricante_id = $_POST["fabricante_id"];

        $query = "UPDATE carros SET 
            modelo='$modelo', 
            categoria='$categoria', 
            tipo_combustivel='$type_fuel', 
            fabricante_id=$fabricante_id
        WHERE 
            id=$carroId";

        $updateResult = $conn->query($query);

        if ($updateResult) {
            header('Location: index.php?message=carro alterado com sucesso!');
            die();
        }
    } catch (Exception $e) {
        $upadeError = $e->getMessage();
    }
}

try {
    $categoryQuery = "SELECT * from fabricantes";
    $categoryResult = $conn->query($categoryQuery);
} catch (Exception $e) {
    header('Location: index.php?message=Erro ao recuperar categorias!');
    die();
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
                Erro ao alterar o carro.
                <?= $error ? $error : var_dump($query) . "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Editar carro</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="fabricante_id" class="form-label">Fabricante</label>
                <select 
                    class="form-control" 
                    id="fabricante_id" 
                    name="fabricante_id"
                    required>
                        <option value></option>

                        <?php while($category = $categoryResult->fetch_assoc()): ?>
                            <option 
                                value="<?=$category["id"]?>"
                                <?= $category["id"] == $carro["fabricante_id"] ? 'selected' : '';?>
                                >
                                <?=$category["nome"]?>
                            </option>
                        <?php endwhile; ?>
                        
                        <?php $categoryResult->close(); ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Nome do carro" value="<?= $carro["modelo"] ?>">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Categoria</label>
                <textarea type="text" class="form-control" id="category" name="category"><?= $carro["categoria"] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="tipo_combustivel" class="form-label">tipo de combustivel</label>
                <input type="text" class="form-control" id="tipo_combustivel" name="tipo_combustivel" value="<?= $carro["tipo_combustivel"] ?>">
            </div>

            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>
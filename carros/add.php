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
    <title>Adicionar carro</title>
</head>

<?php
$result = false;
$error = false;


if ($_POST) {
    try {
        $model = $_POST["model"];
        $category = $_POST["category"];
        $fuel = $_POST["fuel"];
        $carro_id = $_POST["carro_id"];

        $query = "INSERT INTO carros (
            modelo, 
            categoria, 
            tipo_combustivel, 
            fabricante_id
        ) VALUES (
            '$model',
            '$category', 
            '$fuel', 
            $carro_id
        )";

        $result = $conn->query($query);
        $conn->close();

        if ($result) {
            header('Location: index.php?message=carro inserido com sucesso!');
            die();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
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

        <?php if ($_POST && (!$result || $error)) : ?>
            <p>
                Erro salvar o novo carro.
                <?= $error ? $error : "Erro desconhecido." ?>
            </p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Adicionar carro</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="carro_ID" class="form-label">Categoria</label>
                <select 
                    class="form-control" 
                    id="carro_id" 
                    name="carro_id"
                    required>
                        <option value></option>

                        <?php while($category = $categoryResult->fetch_assoc()): ?>
                            <option value="<?=$category["id"]?>">
                                <?=$category["nome"]?>
                            </option>
                        <?php endwhile; ?>
                        
                        <?php $categoryResult->close(); ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">modelo</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Nome do carro">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Categoria</label>
                <textarea type="text" class="form-control" id="category" name="category"></textarea>
            </div>

            <div class="mb-3">
                <label for="fuel" class="form-label">tipo de combustivel</label>
                <input type="text" class="form-control" id="fuel" name="fuel">
            </div>

            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar</button>

        </form>
    </section>

</body>

</html>
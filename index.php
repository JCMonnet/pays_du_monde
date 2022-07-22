<?php
include 'connexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <title>Pays du monde</title>
</head>

<body>
    <header>
        <h1>Population du monde</h1>
        <!--methode GET qui récupère l'id continent ou region dans l'url d'afficher les continents/pays/regions correspondants-->
        <form method="GET">
        <!--le onchange this form submit qui permet d'afficher id continent dans l'url à chaque fois qu'on selectionne qqch dans le select-->
        <select class="w-25 p-3" name="choixcontinent" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
        <!-- rajoute en dur "Monde" comme 1ere ligne du select pour éviter le problème de Afrique que je pouvais pas selectionner-->
        <option value=0>Monde</option>
        <?php foreach ($datasCont as $dc) {?>
            <?php if ($dc["id_continent"] != $idContinent): ?>
                <option value="<?php echo $dc["id_continent"] ?>" ><?php echo $dc["libelle_continent"] ?></option>
            <?php else: ?>
                <option selected value="<?php echo $dc["id_continent"] ?>" ><?php echo $dc["libelle_continent"] ?></option>
            <?php endif;?>
        <?php }?>
        </select>

        <select class="w-25 p-3" name="choixregion" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
        <option value=0>_ _ _</option>
        <?php foreach ($RegionsSelect as $rs) {?>
            <?php if ($rs["id_region"] != $idRegion): ?>
                <option value="<?php echo $rs["id_region"] ?>" ><?php echo $rs["libelle_region"] ?></option>
            <?php else: ?>
                <option selected value="<?php echo $rs["id_region"] ?>" ><?php echo $rs["libelle_region"] ?></option>
            <?php endif;?>
            <?php }?>
        </select>
        </form>
    </header>

    <main>
        <table class="table" class="mt-5">
            <thead class="table-warning">
                <tr>
                    <th scope="col">Pays</th>
                    <th scope="col">Population totale (en milliers)</th>
                    <th scope="col">Taux de natalité</th>
                    <th scope="col">Espérance de vie</th>
                    <th scope="col">Taux de mortalité</th>
                    <th scope="col">Taux de mortalité infantile</th>
                    <th scope="col">Nombre d'enfants par femme</th>
                    <th scope="col">Taux de croissance</th>
                    <th scope="col">Population de 65 ans et plus (en milliers)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datas as $data) {?>
                <tr>
                    <th scope="row"><?=$data["nom"]?></th>
                    <td><?=$data["population_pays"]?></td>
                    <td><?=$data["taux_natalite_pays"]?></td>
                    <td><?=$data["esperance_vie_pays"]?></td>
                    <td><?=$data["taux_mortalite_pays"]?></td>
                    <td><?=$data["taux_mortalite_infantile_pays"]?></td>
                    <td><?=$data["nombre_enfants_par_femme_pays"]?></td>
                    <td><?=$data["taux_croissance_pays"]?></td>
                    <td><?=$data["population_plus_65_pays"]?></td>
                </tr>
                <?php }?>
            </tbody>
            <tfooter>
            <?php foreach ($totaux as $total) {?>
                <tr>
                    <th scope="row"><?=$total["nom"]?></th>
                    <td><?=$total["population_pays"]?></td>
                    <td><?=$total["taux_natalite_pays"]?></td>
                    <td><?=$total["esperance_vie_pays"]?></td>
                    <td><?=$total["taux_mortalite_pays"]?></td>
                    <td><?=$total["taux_mortalite_infantile_pays"]?></td>
                    <td><?=$total["nombre_enfants_par_femme_pays"]?></td>
                    <td><?=$total["taux_croissance_pays"]?></td>
                    <td><?=$total["population_plus_65_pays"]?></td>
                </tr>
                <?php }?>
            </tfooter>
        </table>
    </main>
</body>

</html>
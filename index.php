<?php
include 'connexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Pays du monde</title>
</head>

<body>
    <header>
        <h1>Population du monde</h1>
        <!--methode GET qui récupère l'id continent ou region dans l'url d'afficher les continents/pays/regions correspondants-->
        <form method="GET">
            <!--le onchange this form submit qui permet d'afficher id continent dans l'url à chaque fois qu'on selectionne qqch dans le select-->
            <select id="selectContinent" class="w-60 p-3" name="choixcontinent" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                <!-- rajoute en dur "Monde" comme 1ere ligne du select pour éviter le problème de Afrique que je pouvais pas selectionner-->
                <option value=0>Continents</option>
                <?php foreach ($datasCont as $dc) { ?>
                    <?php if ($dc["id_continent"] != $idContinent) : ?>
                        <option value="<?php echo $dc["id_continent"] ?>"><?php echo $dc["libelle_continent"] ?></option>
                    <?php else : ?>
                        <option selected value="<?php echo $dc["id_continent"] ?>"><?php echo $dc["libelle_continent"] ?></option>
                    <?php endif; ?>
                <?php } ?>
            </select>
            <img src="https://thumbs.dreamstime.com/z/population-du-monde-13912340.jpg" alt="">
            <select id="selectRegion" class="w-60 p-3" name="choixregion" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                <option value=0>Régions</option>
                <?php foreach ($RegionsSelect as $rs) { ?>
                    <?php if ($rs["id_region"] != $idRegion) : ?>
                        <option value="<?php echo $rs["id_region"] ?>"><?php echo $rs["libelle_region"] ?></option>
                    <?php else : ?>
                        <option selected value="<?php echo $rs["id_region"] ?>"><?php echo $rs["libelle_region"] ?></option>
                    <?php endif; ?>
                <?php } ?>
            </select>
        </form>
    </header>

    <main>
            <table class="table" class="mt-5">
                <thead  class="text-primary">
                    <tr>
                        <th scope="col">Pays</th>
                        <th scope="col">Population totale (en milliers)</th>
                        <th scope="col">Taux de natalité %</th>
                        <th scope="col">Espérance de vie </th>
                        <th scope="col">Taux de mortalité %</th>
                        <th scope="col">Taux de mortalité infantile en %</th>
                        <th scope="col">Nombre d'enfants par femme</th>
                        <th scope="col">Taux de croissance %</th>
                        <th scope="col">Population de 65 ans et plus (en milliers)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datas as $data) { ?>
                        <tr>
                            <th scope="row" class="text-light bg-dark"><?= $data["nom"] ?></th>
                            <td><?= round($data["population_pays"], 1) ?></td>
                            <td class="text-light bg-dark"><?= round($data["taux_natalite_pays"], 1) ?></td>
                            <td><?= round($data["esperance_vie_pays"], 1) ?></td>
                            <td class="text-light bg-dark"><?= round($data["taux_mortalite_pays"], 1) ?></td>
                            <td><?= round($data["taux_mortalite_infantile_pays"], 1) ?></td>
                            <td class="text-light bg-dark"><?= round($data["nombre_enfants_par_femme_pays"], 1) ?></td>
                            <td><?= round($data["taux_croissance_pays"], 1) ?></td>
                            <td class="text-light bg-dark"><?= round($data["population_plus_65_pays"], 1) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfooter >
                    <?php foreach ($totaux as $total) { ?>
                        <tr>
                            <th class="text-warning bg-dark" scope="row">TOTAL<br> <?= $total["nom"] ?></th>
                            <td class="text-warning bg-dark"><?= $total["population_pays"] ?></td>
                            <td class="text-warning bg-dark"><?= round($total["taux_natalite_pays"], 1) ?></td>
                            <td class="text-warning bg-dark"><?= round($total["esperance_vie_pays"], 1) ?></td>
                            <td class="text-warning bg-dark"><?= round($total["taux_mortalite_pays"], 1) ?></td>
                            <td class="text-warning bg-dark"><?= round($total["taux_mortalite_infantile_pays"], 1) ?></td>
                            <td class="text-warning bg-dark"><?= round($total["nombre_enfants_par_femme_pays"], 1) ?></td>
                            <td class="text-warning bg-dark"><?= round($total["taux_croissance_pays"], 1) ?></td>
                            <td class="text-warning bg-dark"><?= round($total["population_plus_65_pays"], 1) ?></td>
                        </tr>
                    <?php } ?>
                </tfooter>
            </table>
    </main>
    <footer>
        <p> La plus grande menace à notre planète est la conviction que <span>quelqu’un d’autre</span> va la sauver. </p>
    </footer>
</body>
</html>
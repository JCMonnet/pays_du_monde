<?php
// relie à la BD
try {
    $BDD = new PDO(
        'mysql:host=localhost:3308;dbname=pays;charset=utf8', 'Userpays', '111111'
    );} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}

// requête pour liste continents dans le select
$req = $BDD->prepare('SELECT * FROM t_continents GROUP BY libelle_continent');
$req->execute();
$datasCont = $req->fetchAll();

// requête pour liste regions dans le select
$req = $BDD->prepare('SELECT * FROM t_regions GROUP BY libelle_region');
$req->execute();
$RegionsSelect = $req->fetchAll();

//  requête pour récupérer les totaux pour chaque pays et création alias
$req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) GROUP BY nom');
$req->execute();
$datas = $req->fetchAll();

// requête pour récupérer regions en fonction du continent dans le select
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent']) {
    $req = $BDD->prepare('SELECT id_region,libelle_region FROM `t_regions` WHERE t_regions.continent_id=' . $_GET['choixcontinent']);
    $req->execute();
    $RegionsSelect = $req->fetchAll();
// ajout variable pour mettre dans le if else dans index pour garder à l'ecran le continent selectionné
    $idContinent = $_GET['choixcontinent'];
}

//requête pour récupérer regions en fonction du continent dans le tableau
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent']) {
    $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
    $req->execute();
    $datas = $req->fetchAll();
}

//requête pour récupérer pays en fonction de la region dans le tableau
if (isset($_GET['choixregion']) && $_GET['choixregion']) {
    $req = $BDD->prepare('SELECT libelle_pays AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.id_region=' . $_GET['choixregion'] . ' GROUP BY libelle_pays ');
    $req->execute();
    $datas = $req->fetchAll();
//  ajout variable pour mettre dans le if else dans index pour garder à l'ecran la region selectionnée
    $idRegion = $_GET['choixregion'];
}

//requête pour récupérer Canada et Etats Unis (sans region) dans le tableau: methode ID -
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 3) {
    $req = $BDD->prepare('SELECT libelle_pays AS  nom, SUM(population_pays) AS population_pays , AVG(taux_natalite_pays) AS taux_natalite_pays, AVG(taux_mortalite_pays) AS taux_mortalite_pays, AVG(esperance_vie_pays) AS esperance_vie_pays, AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays, AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays, AVG(taux_croissance_pays) AS taux_croissance_pays, SUM(population_plus_65_pays) AS population_plus_65_pays FROM t_pays
    INNER JOIN t_continents  ON t_continents.id_continent = t_pays.continent_id
    WHERE t_pays.continent_id=3
    GROUP BY t_pays.libelle_pays');
    $req->execute();
    $datas = $req->fetchAll();
}

//requête pour récupérer Canada et Etats Unis (sans region) dans le tableau: methode COUNT(data) +
// if (isset($_GET['choixcontinent']) && $_GET['choixcontinent']) {
//     $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
//     $req->execute();
//     $datas = $req->fetchAll();
// }
// if (count($datas) == 0) {
//     $req = $BDD->prepare('SELECT libelle_pays AS  nom, SUM(population_pays) AS population_pays , AVG(taux_natalite_pays) AS taux_natalite_pays, AVG(taux_mortalite_pays) AS taux_mortalite_pays, AVG(esperance_vie_pays) AS esperance_vie_pays, AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays, AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays, AVG(taux_croissance_pays) AS taux_croissance_pays, SUM(population_plus_65_pays) AS population_plus_65_pays FROM t_pays
//     INNER JOIN t_continents  ON t_continents.id_continent = t_pays.continent_id WHERE libelle_continent LIKE ("Amérique Septentrionale")
//     GROUP BY t_pays.libelle_pays ');
//     $req->execute();
//     $datas = $req->fetchAll();
// }

//requête totaux footer tab
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] && $_GET['choixregion'] == 0) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
if (isset($_GET['choixregion']) && $_GET['choixregion']) {
    $req = $BDD->prepare('SELECT libelle_region AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.id_region=' . $_GET['choixregion'] . ' GROUP BY libelle_region ');
    $req->execute();
    $totaux = $req->fetchAll();
}

if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 0) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom, SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM t_continents INNER JOIN t_pays ON t_continents.id_continent=t_pays.continent_id WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}

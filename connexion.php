<?php
// relie à la BD
try {
    $BDD = new PDO(
        'mysql:host=localhost:3306;dbname=pays;charset=utf8',
        'Userpays',
        '111111'
    );
} catch (PDOException $e) {
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

//requête totaux footer tab (par continent/region/accueil et monde)

if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] && $_GET['choixregion'] == 0) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
}
if (isset($_GET['choixregion']) && $_GET['choixregion']) {
    $req = $BDD->prepare('SELECT libelle_region AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.id_region=' . $_GET['choixregion'] . ' GROUP BY libelle_region ');
}

//pour obtenir total monde à l'accueil ou si select monde (si aucun choix continent ou si = à 0)
if (!isset($_GET['choixcontinent']) || $_GET['choixcontinent'] == 0) {
    $req = $BDD->prepare('SELECT "Monde" AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) ');
}
//optimisation éxecuter qu'une fois la requete une fois le if correspondant trouvé
$req->execute();
$totaux = $req->fetchAll();

//correction pb affichage si nouvelle recherche continent
// Afrique
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 1 && ($_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
    $req->execute();
    $datas = $req->fetchAll();
}

//Amerique latine et caraibes
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 2  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
    $req->execute();
    $datas = $req->fetchAll();
}
//Amerique septentrionale
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 3  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18|| $_GET['choixregion'] == 19|| $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT libelle_pays AS  nom, SUM(population_pays) AS population_pays , AVG(taux_natalite_pays) AS taux_natalite_pays, AVG(taux_mortalite_pays) AS taux_mortalite_pays, AVG(esperance_vie_pays) AS esperance_vie_pays, AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays, AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays, AVG(taux_croissance_pays) AS taux_croissance_pays, SUM(population_plus_65_pays) AS population_plus_65_pays FROM t_pays
    INNER JOIN t_continents  ON t_continents.id_continent = t_pays.continent_id
    WHERE t_pays.continent_id=3
    GROUP BY t_pays.libelle_pays');
    $req->execute();
    $datas = $req->fetchAll();
}
//Asie
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 4  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20 )) {
    $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
    $req->execute();
    $datas = $req->fetchAll();
}
//Europe
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 5  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20 )) {
    $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
    $req->execute();
    $datas = $req->fetchAll();
}
//Oceanie
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 6  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 )) {
    $req = $BDD->prepare('SELECT id_region,libelle_region AS "nom",SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_regions` INNER JOIN t_pays ON (t_regions.id_region=t_pays.region_id) WHERE t_regions.continent_id=' . $_GET['choixcontinent'] . ' GROUP BY libelle_region ');
    $req->execute();
    $datas = $req->fetchAll();
}
//Monde
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 0  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17|| $_GET['choixregion'] == 18|| $_GET['choixregion'] == 19|| $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) GROUP BY libelle_continent ');
    $req->execute();
    $datas = $req->fetchAll();
}
// Total Afrique
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 1 && ($_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
//Total Amerique latine et caraibes
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 2  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
//Total Amerique septentrionale
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 3  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18|| $_GET['choixregion'] == 19|| $_GET['choixregion'] == 20)) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
//Total Asie
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 4  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20 )) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
//Total Europe
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 5  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 12 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 18 || $_GET['choixregion'] == 19 || $_GET['choixregion'] == 20 )) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
//Total Oceanie
if (isset($_GET['choixcontinent']) && $_GET['choixcontinent'] == 6  && ($_GET['choixregion'] == 1 || $_GET['choixregion'] == 2 || $_GET['choixregion'] == 3 || $_GET['choixregion'] == 4 || $_GET['choixregion'] == 5 || $_GET['choixregion'] == 6 || $_GET['choixregion'] == 7 || $_GET['choixregion'] == 8 || $_GET['choixregion'] == 9 || $_GET['choixregion'] == 10 || $_GET['choixregion'] == 11 || $_GET['choixregion'] == 13 || $_GET['choixregion'] == 14 || $_GET['choixregion'] == 15 || $_GET['choixregion'] == 16 || $_GET['choixregion'] == 17 )) {
    $req = $BDD->prepare('SELECT libelle_continent AS nom,SUM(population_pays) AS population_pays,AVG(taux_natalite_pays) AS taux_natalite_pays,AVG(taux_mortalite_pays) AS taux_mortalite_pays,AVG(esperance_vie_pays) AS esperance_vie_pays,AVG(taux_mortalite_infantile_pays) AS taux_mortalite_infantile_pays,AVG(nombre_enfants_par_femme_pays) AS nombre_enfants_par_femme_pays,AVG(taux_croissance_pays)AS taux_croissance_pays ,AVG(population_plus_65_pays) AS population_plus_65_pays FROM `t_continents` INNER JOIN t_pays ON (t_continents.id_continent=t_pays.continent_id) WHERE t_continents.id_continent=' . $_GET['choixcontinent'] . ' GROUP BY libelle_continent');
    $req->execute();
    $totaux = $req->fetchAll();
}
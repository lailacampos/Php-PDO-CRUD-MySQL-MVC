<?php

require("database.php");

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$city = htmlspecialchars($_GET["city"]);
$countryCode = htmlspecialchars($_POST["country-code"]);
$district = htmlspecialchars($_POST["district"]);
$population = htmlspecialchars($_POST["population"]);

if ($id) {

    $query = "UPDATE city SET Name = :city,
                CountryCode = :countryCode,
                District = :district,
                Population = :population
                WHERE ID = :id";

    $statement = $db->prepare($query);

    $statement->bindValue(":city", $city);
    $statement->bindValue(":countryCode", $countryCode);
    $statement->bindValue(":district", $district);
    $statement->bindValue(":population", $population);
    $statement->bindValue(":id", $id);

    $success = $statement->execute();

    $statement->closeCursor();
}

$updated = true;

include("index.php");

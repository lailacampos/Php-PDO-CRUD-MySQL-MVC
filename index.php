<?php

$city = htmlspecialchars($_GET["city"]);
$newCity = htmlspecialchars($_POST["newCity"]);
$countryCode = htmlspecialchars($_POST["countrycode"]);
$district = htmlspecialchars($_POST["district"]);
$population = htmlspecialchars($_POST["population"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO Tutorial</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <main>
        <header>
            <h1>PHP PDO Tutorial</h1>
        </header>

        <?php
        if (isset($deleted)) {
            echo "Record deleted.<br><br>";
        } else if (isset($updated)) {
            echo "Record updated.<br><br>";
        }
        ?>

        <?php if (!$city && !$newCity) { ?>

            <section>
                <h2>Select Data / Read Data</h2>
                <form action="." method="GET">
                    <label for="city">City Name:</label>
                    <input type="text" name="city" id="city" required>
                    <button type="submit">Submit</button>
                </form>
            </section>
            <section>
                <h2>Insert Data / Create Data</h2>
                <form action="." method="POST">
                    <label for="newCity">City Name:</label>
                    <input type="text" name="newCity" id="newCity" required>

                    <label for="countrycode">Country Code:</label>
                    <input type="text" name="countrycode" id="countrycode" maxlength="3" required>

                    <label for="district">District:</label>
                    <input type="text" name="district" id="district" required>

                    <label for="population">Population:</label>
                    <input type="text" name="population" id="population" required>
                    <button type="submit">Submit</button>
                </form>
            </section>
        <?php } else { ?>
            <?php require("database.php"); ?>
            <?php

            if ($newCity) {

                $query = "INSERT INTO city
                            (Name, CountryCode, District, Population)
                            VALUES(
                                :newCity, :countryCode, :district, :newPopulation
                            )";

                $statement = $db->prepare($query);
                $statement->bindValue(":newCity", $newCity);
                $statement->bindValue(":countryCode", $countryCode);
                $statement->bindValue(":district", $district);
                $statement->bindValue(":newPopulation", $population);

                $statement->execute();
                $statement->closeCursor();
            }

            if ($city || $newCity) {

                $query = "SELECT * FROM city 
                                WHERE Name = :city 
                                ORDER BY Population";

                $statement = $db->prepare($query);

                if ($city) {
                    $statement->bindValue(":city", $city);
                } else {
                    $statement->bindValue(":city", $newCity);
                }

                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closeCursor();
            }
            ?>
            <?php if (!empty($results)) { ?>
                <section>
                    <h2>Update or Delete Data</h2>
                    <?php
                    foreach ($results as $result) {
                        $id = $result["ID"];
                        $city = $result["Name"];
                        $countryCode = $result["CountryCode"];
                        $district = $result["District"];
                        $population = $result["Population"];

                    ?>
                        <form class="update" action="update_record.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                            <label for="city-<?php echo $id; ?>">City Name:</label>
                            <input type="text" name="city" id="city-<?php echo $id; ?>" value="<?php echo $city; ?>" required>

                            <label for="countrycode-<?php echo $id; ?>">Country Code:</label>
                            <input type="text" name="countrycode" id="countrycode-<?php echo $id; ?>" value="<?php echo $countryCode; ?>" required>

                            <label for="district-<?php echo $id; ?>">District:</label>
                            <input type="text" name="district" id="district-<?php echo $id; ?>" value="<?php echo $district; ?>" required>

                            <label for="population-<?php echo $id; ?>">Population:</label>
                            <input type="text" name="population" id="population-<?php echo $id; ?>" value="<?php echo $population; ?>" required>

                            <button type="submit">Update</button>
                        </form>
                        <form class="delete" action="delete_record.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button class="red">Delete</button>
                        </form>
                    <?php } ?>
                </section>
            <?php } else { ?>
                <p>Sorry, no results :(</p>
            <?php } ?>
            <a href=".">Go to Request Form</a>
        <?php } ?>
    </main>
</body>

</html>
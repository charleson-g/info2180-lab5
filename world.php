<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    // Optionally handle connection errors here
    die("Connection failed: " . $e->getMessage());
}

// Retrieve the country name from the GET request variable
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? '';

if ($lookup === 'cities') {
    // SQL Query to find cities in the specified country
    $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE :country");
    $stmt->bindValue(':country', '%' . $country . '%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>District</th>';
        echo '<th>Population</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['district']) . '</td>';
            echo '<td>' . htmlspecialchars($row['population']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No cities found matching your search.</p>';
    }

} else {
    // SQL Query to find countries matching the search term
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', '%' . $country . '%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results as an HTML table
    if (!empty($results)) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Country Name</th>';
        echo '<th>Continent</th>';
        echo '<th>Independence Year</th>';
        echo '<th>Head of State</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['continent']) . '</td>';
            echo '<td>' . htmlspecialchars($row['independence_year'] ?? 'N/A') . '</td>';
            echo '<td>' . htmlspecialchars($row['head_of_state']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No countries found matching your search.</p>';
    }
}
?>
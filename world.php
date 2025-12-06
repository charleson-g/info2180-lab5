<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// 1. Retrieve the country name from the GET request variable
$country_name = $_GET['country'] ?? '';

// 2. Define the dynamic SQL Query using the LIKE operator
$sql = "SELECT * FROM countries WHERE name LIKE '%$country_name%'";

// 3. Execute the dynamic query
$stmt = $conn->query($sql);

// 4. Fetch results as an associative array
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<ul>';
foreach ($results as $row) {
    // Assuming 'name' and 'head_of_state' are common columns returned by SELECT *
    echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
}
echo '</ul>';

// PHP closing tag can be omitted if the file contains only PHP code, but is included here
// mirroring the style seen in the provided starter excerpts [1, 2].
?>
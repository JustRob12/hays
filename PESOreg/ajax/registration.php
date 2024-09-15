<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0); // Exit for preflight requests
}

// Connect to the database
$host = 'localhost';
$db = 'persoreg';
$user = 'root'; // Update as needed
$pass = ''; // Update as needed

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'], $data['age'], $data['dob'], $data['contactNumber'], $data['gmail'], $data['religion'], $data['address'], $data['province'], $data['purpose'], $data['regDate'])) {
    $stmt = $conn->prepare("INSERT INTO reg (name, age, dob, contactNumber, gmail, religion, address, province, purpose, regDate) 
                            VALUES (:name, :age, :dob, :contactNumber, :gmail, :religion, :address, :province, :purpose, :regDate)");
    $stmt->execute([
        'name' => $data['name'],
        'age' => $data['age'],
        'dob' => $data['dob'],
        'contactNumber' => $data['contactNumber'],
        'gmail' => $data['gmail'],
        'religion' => $data['religion'],
        'address' => $data['address'],
        'province' => $data['province'],
        'purpose' => $data['purpose'],
        'regDate' => $data['regDate']
    ]);

    echo json_encode(['message' => 'Registration successful!']);
} else {
    echo json_encode(['message' => 'Invalid input data']);
}
?>

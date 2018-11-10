<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
/*
================================================
Connection to DB and check
================================================
*/
$server_name = "localhost";
$user_name = "root";
$pass = "";

$db_name = "customdb";

//$connection = new mysqli($server_name, $user_name, $pass, $db_name);
$connection = new mysqli($server_name, $user_name, $pass, 'mydb');

if($connection->connect_error){
    die("connection failed");
}
echo "<div> 
<h3>Connected!</h3> 
</div>";

/*
================================================
Create a MySQL Database
================================================
*/

$sql = "CREATE DATABASE myDB";
if($connection->query($sql) === TRUE){
 echo "<div>Database created successfully</div>";
}else{
 echo "<div>Error creating database: ".$connection->error."</div>";
}

$connection->close();

/*
================================================
Create a MySQL Table
================================================
*/

$sql = "CREATE TABLE MyGuests(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($connection->query($sql)=== TRUE){
 echo "<div>Table is created successfully</div>";
}else{
 echo "<div>Error creating table:".$connection->error."</div>";
}

$connection->close();

/*
================================================
Insert MySQL Data
================================================
*/

$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";

if($connection->query($sql) === TRUE){
 echo "<div>New record is created successfully</div>";
}else{
 echo "<div>Error adding new data:".$connection->error."</div>";
}

$connection->close();

/*
================================================
Get Last ID
================================================
*/

$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Joseph', 'Smith', 'joseph@example.com')";

if($connection->query($sql) === TRUE){
 $last_id = $connection->insert_id;
 echo "<div>New record is created successfully. Last inserted ID is: ".$last_id."</div>";
}else{
 echo "<div>Error adding new data:".$connection->error."</div>";
}

$connection->close();

/*
================================================
Prepared Statements in MySQLi
================================================
*/

$stmt = $connection->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?,?,?)");
$stmt->bind_param("sss", $firstname, $lastname, $email);

$firstname = 'Anna';
$lastname = "Prior";
$email = "anna@example.com";
$stmt->execute();

$firstname = "Mary";
$lastname = "Moe";
$email = "mary@example.com";
$stmt->execute();

$firstname = "Julie";
$lastname = "Dooley";
$email = "julie@example.com";
$stmt->execute();

echo "New records created successfully";

$stmt-> close();
$connection->close();

/*
================================================
            Select Data with MySQLi
================================================
*/
function showTable($conn){
    $sql = "SELECT id, firstname, lastname FROM MyGuests";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        // output data of each row
        while($row = $result->fetch_assoc()){
            echo "<div>id: ".$row["id"]." - Name: ".$row["firstname"]." ".$row["lastname"]."</div>";
        }
    }else{
        echo "0 results";
    }

    $conn->close();
}


/*
================================================
            Delete Data with MySQLi
================================================
*/

//showTable($connection);?????????

$delete_sql = "DELETE FROM MyGuests WHERE id='1'";
if ($connection->query($delete_sql) === TRUE){
    echo "<div>Record deleted successfully</div>";
} else {
    echo "<div>Error deleting record: ".$connection->error."</div>";
}

$connection->close();

//showTable($connection);????????????


/*
================================================
            Set parameters with MySQLi
================================================
*/

$sql = "UPDATE MyGuests SET id=1 WHERE lastname='Doe'";

if($connection->query($sql) === TRUE){
        echo "<div>Record updated successfully</div>";
}else{
        echo "<div>Error updating record: ".$connection->error."</div>";
}

$connection->close();
?>




</body>
</html>
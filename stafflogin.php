<html>
    <Title>Toy Store</Title>
    <body>

<?php
$username = $_POST["username"];
$password = $_POST["password"];

if($username == null || $password == null){
	header("Location: ./milestone3.php");
}

// Now, we will create a mysqli object and connect to database
$host = 'localhost';//enter hostname
$userName = 'root';//enter user name of DB
$Pass = 'pwd'; //enter password
$DB = 'TOYS_ORDERS'; //Enter database name
$mysqli = new mysqli($host, $userName,$Pass,$DB);

// Check for connection error
// If there is an error we will use $mysqli->connect_error
// to print the cause of the error
if ($mysqli->connect_errno) {
	echo "Could not connect to database \n";
	echo "Error: ". $mysqli->connect_error . "\n";
	exit;
} 
else {

	// Let's write the query and store it in a variable
	$user_query = "
	SELECT USERNAME, PW 
	FROM PEOPLE 
	WHERE (USERNAME = '$username' AND PW = '$password')";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows > 0 && $q_result > 0) {
        if($q_result == 1) {
            $resulting_string = "<br> Welcome back user: ". $username. "<br \>";
            setupHTML("");
            startEmployeePage($resulting_string);
        }
        if($q_result == 2) {
            $resulting_string = "<br> Welcome back user: ". $username. "<br \>";
            setupHTML("");
            startEmployeePage($resulting_string);
            startManagerPage($resulting_string);
        }
	}
	else {
		header("Location: ./shopping.php");
	}
	
}
function setupHTML($input){
	echo "
	<body>
	<Title>Toy Store</Title>

	<h1>Welcome to the Ultimate Toy Shopping Experience (for Employees)</h1>

	<h2>". $input ."</h2>
    
	</body>
	<style> 
	input[type=button], input[type=submit], input[type=reset] {
	background-color: #4CAF50;
	border: none;
	color: white;
	padding: 16px 32px;
	text-decoration: none;
	margin: 4px 2px;
	cursor: pointer;
	}
	</style>
    ";
}

function startEmployeePage($input) {
    echo " <h3> Inventory: </h3>";
    displayInventory();

    echo "<h3> Add Item: </h3>
        <table>
        <td>Product Name:</td> <td><input type=\"text\" name=\"name\"></td>
        <td>Inventory ID:</td> <td><input type=\"text\" name=\"id\"></td>
        <td>Amount:</td> <td><input type=\"text\" name=\"amount\"></td>
        <td>Price:</td> <td><input type=\"text\" name=\"price\"></td>
        <td>Description:</td> <td><input type=\"text\" name=\"description\"></td>
        </table>
        <input type=\"submit\">
    ";

    displayOrders();

    echo " <h3> Ship Order: </h3>
        <table>
        <td>Order ID::</td> <td><input type=\"text\" name=\"name\"></td>
        <td>Inventory ID:</td> <td><input type=\"text\" name=\"id\"></td>
        </table>
        <input type=\"submit\">
    ";

}

function displayInventory() {
    $user_query = "
	SELECT * 
	FROM INVENTORY";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($q_result)){
            addItem($row["PRODUCT_NAME"], $row["INVENTORY_ID"], $row["AMOUNT"], $row["PRICE"], ($row["PRODUCT_DESC"]));
        }
	}
	else {
		echo "<h3> Inventory is empty, please add items. </h3>";
    }
}

function displayOrders() {
    $user_query = "
	SELECT * 
	FROM ORDERS";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($q_result)){
            addOrderItem($row["ORDER_ID"], $row["INVENTORY_ID"], $row["PERSON_ID"], $row["ORDER_STATUS"], ($row["QUANTITY"]));
        }
	}
	else {
		echo "<h3> Orders is empty. </h3>";
    }
}

function addInventoryItem($name, $id, $amount, $price, $description){
    echo "
    <div>
        <table id='customers' cellpadding='5'>
            <td>".$name." </td>
            <td>".$id." </td>
            <td>".$amount." </td>
            <td>".$price." </td>
            <td>".$description." </td>
        </table>
        <input type='hidden' name='name' value='".$name."'>
        
    </div>
    ";
}

function addOrderItem($orderid, $inventoryid, $personid, $orderstatus, $quantity){
    echo "
    <div>
        <table id='customers' cellpadding='5'>
            <td>".$orderid." </td>
            <td>".$inventoryid." </td>
            <td>".$personid." </td>
            <td>".$orderstatus." </td>
            <td>".$quantity." </td>
        </table>
        <input type='hidden' name='name' value='".$name."'>
        
    </div>
    ";
}
?>
</body>
</html>

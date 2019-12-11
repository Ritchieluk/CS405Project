<html>
    <Title>Toy Store</Title>
    <body>

<?php
$username = $_POST["username"];
$password = $_POST["password"];
$action = $_POST["action_type"];

if(($username == null || $password == null) && $action==null){
	header("Location: ./milestone3.php");
}
else if ($action == 'Ship It!'){
    # mark an order as completed
    shipIt();
}
else if ($action == 'Add Item to Inventory'){
    addIt();
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
    $user_query;
    if($_COOKIE['employee'] != null){
        $user_query = "
        SELECT USERNAME, PERSON_ID, PERSON_TYPE AS TYPE
        FROM PEOPLE 
        WHERE PERSON_ID=".$_COOKIE['employee'];
    }
    else {
        $user_query = "
        SELECT USERNAME, PERSON_ID, PERSON_TYPE AS TYPE
        FROM PEOPLE 
        WHERE (USERNAME = '$username' AND PW = '$password') AND (PERSON_TYPE=2 OR PERSON_TYPE=3)";
    }
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows == 0) {
        # Redirect to Homepage. 
        $string = "<h2>You're not an employee silly!</h2>
        <form action='milestone3.php' method='post'>
        <input type='submit' value='Go Home'>
        </form>";
        setupHTML($string);
    }
    else if($q_result->num_rows > 0){
        # Determine which type of user
        $row = mysqli_fetch_assoc($q_result);
        if ($row["TYPE"] == 2 ){
            # build for employees
            setcookie("employee", $row["PERSON_ID"], time()+10000);
            $string = "<h2>Welcome back employee '".$row['USERNAME']."'</h2>";
            setupHTML($string);
            startEmployeePage();
        }
        else if($row["TYPE"]==3){
            # build for manager
            setcookie("employee", $row["PERSON_ID"], time()+10000);
            setcookie("manager", $row["PERSON_ID"], time()+10000);
            $string = "<h2>Welcome back manager '".$row['USERNAME']."'</h2>";
            setupHTML($string);
            startEmployeePage();
            # TODO: Add Manager functions/routes
        }
        else{
            # WHO IS THIS PERSON?
            $string = "<h2>Who even are you?!</h2>
            <form action='milestone3.php' method='post'>
            <input type='submit' value='Go Home You Demon'>
            </form>";
            setupHTML($string);
        }
    }
	else {
		header("Location: ./shopping.php");
	}
	
}

function shipIt(){
    $orderid = $_POST["order_id"];
    $inventoryid = $_POST["inventory_id"];

    $host = 'localhost';//enter hostname
    $userName = 'root';//enter user name of DB
    $Pass = 'pwd'; //enter password
    $DB = 'TOYS_ORDERS'; //Enter database name
    $mysqli = new mysqli($host, $userName,$Pass,$DB);
    $user_query = "
    UPDATE ORDERS
    SET ORDER_STATUS = 'shipped'
    WHERE ORDER_ID=".$orderid." AND INVENTORY_ID=".$inventoryid;
	
    $q_result = $mysqli->query($user_query);
    if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
    
}

function addIt(){
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $host = 'localhost';//enter hostname
    $userName = 'root';//enter user name of DB
    $Pass = 'pwd'; //enter password
    $DB = 'TOYS_ORDERS'; //Enter database name
    $mysqli = new mysqli($host, $userName,$Pass,$DB);
    $user_query = "
    INSERT 
    INTO INVENTORY (AMOUNT, PRICE, PRODUCT_NAME, PRODUCT_DESC)
    VALUES (".$amount.", ".$price.",'".$name."','".$description."')";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
}


function startEmployeePage() {
    echo " <h3> Inventory: </h3>";
    displayInventory();

    echo "
    <hr>
    <h3> Add Item: </h3>
    <form action='stafflogin.php' method='post'>
        <table class='customers'>
        <tr>
            <td>Product Name:</td> <td><input type='text' name='name'></td>
            <td>Amount:</td> <td><input type='number' name='amount'></td>
            <td>Price:</td> <td><input type='number' name='price' step='0.01'></td>
            <td>Description:</td> <td><input type='text' name='description'></td>
        </tr>
        </table>
        <input type='submit' name='action_type' value='Add Item to Inventory'>
    </form>
    <hr>
    <h3> Order History </h3>
    ";
    
    displayOrders();

}

function displayInventory() {
    $host = 'localhost';//enter hostname
    $userName = 'root';//enter user name of DB
    $Pass = 'pwd'; //enter password
    $DB = 'TOYS_ORDERS'; //Enter database name
    $mysqli = new mysqli($host, $userName,$Pass,$DB);
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
        echo "
        <div>
        <table id='customers' cellpadding='5'>
            <th>Product</th>
            <th>Product Page</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Description</th>
            <th>Edit Item</th>
        ";
        while($row = mysqli_fetch_assoc($q_result)){
            addInventoryItem($row["PRODUCT_NAME"], $row["INVENTORY_ID"], $row["AMOUNT"], $row["PRICE"], ($row["PRODUCT_DESC"]));
        }
        echo "
        </table>
            </div>
            <style>
                #customers {
                font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                table-layout: fixed;
                }

                #customers td, #customers th {
                border: 1px solid #ddd;
                height: 40px;
                }

                #customers tr:nth-child(even){background-color: #f2f2f2;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
                }
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
	else {
		echo "<h3> Inventory is empty, please add items. </h3>";
    }
}

function displayOrders() {
    $host = 'localhost';//enter hostname
    $userName = 'root';//enter user name of DB
    $Pass = 'pwd'; //enter password
    $DB = 'TOYS_ORDERS'; //Enter database name
    $mysqli = new mysqli($host, $userName,$Pass,$DB);
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
        echo "
        <div>
        <table id='customers' cellpadding='5'>
            <th>Order ID</th>
            <th>Inventory ID</th>
            <th>Person ID</th>
            <th>Status</th>
            <th>Quantity</th>
            <th>Ship It</th>
        ";
        while($row = mysqli_fetch_assoc($q_result)){
            addOrderItem($row["ORDER_ID"], $row["INVENTORY_ID"], $row["PERSON_ID"], $row["ORDER_STATUS"], ($row["QUANTITY"]));
        }
        echo "
        </table>
            </div>
            ";
	}
	else {
		echo "<h3> Orders is empty. </h3>";
    }
}

function addInventoryItem($name, $id, $amount, $price, $description){
    echo "
        <tr>
            <td>".$name." </td>
            <td>
                <form action='productpage.php' method='post'>
                <input type='submit' value='View Product Page'>
                <input type='hidden' value='".$id."' name='name'>
                </form>
            </td>
            <td>".$amount." </td>
            <td>".$price." </td>
            <td>".$description." </td>
            <td>
                <form action='update_inventory.php' method='post'>  
                <input type='submit' value='Edit Inventory Item'>
                <input type='hidden' name='id' value='".$id."'>
                </form>
            </td>
        </tr>
        
    ";
}

function addOrderItem($orderid, $inventoryid, $personid, $orderstatus, $quantity){
    echo "
    <tr>
        <td>".$orderid." </td>
        <td>".$inventoryid." </td>
        <td>".$personid." </td>
        <td>".$orderstatus." </td>
        <td>".$quantity." </td>
        <td>
            <form action='stafflogin.php' method='post'>
            <input type='submit' name='action_type' value='Ship It!'>
            <input type='hidden' name='order_id' value='".$orderid."'>
            <input type='hidden' name='inventory_id' value='".$inventoryid."'>
            </form>
    </tr>
    ";
}

function managerFunctions(){
    echo "
    <h3>Manager Functions</h3>
    <hr>
    <form action='stats.php' method='post'>
    <input type='submit' name='stats' value='Sales Statistics'>
    </form>
    <form action='promotions.php' method='post'>
    <input type='submit' name='promotions' value='View Promotions'>
    </form>
    "
}

function setupHTML($input){
	echo "
    <body>
    <style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
        }
    
        li {
        float: left;
        }
    
        li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }
    
        li a:hover {
        background-color: #111;
        }
        </style>
        </head>
        <body>
    
        <ul>
        <li><a class='active' href='/milestone3.php'>Home</a></li>
        <li><a href='/shopping.php'>Shopping</a></li>
        <li><a href='/cart.php'>My Cart</a></li>
        <li><a href='/orders.php'>My Orders</a></li>
        <li><a href='/logout.php'>Logout</a></li>
        </ul>
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

?>
</body>
</html>

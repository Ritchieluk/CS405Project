<?php
$id = $_POST['id'];

$host = 'localhost';//enter hostname
$userName = 'root';//enter user name of DB
$Pass = 'pwd'; //enter password
$DB = 'TOYS_ORDERS'; //Enter database name
$mysqli = new mysqli($host, $userName,$Pass,$DB);
setupHTML("Update Inventory Screen");
if ($mysqli->connect_errno) {
	echo "Could not connect to database \n";
	echo "Error: ". $mysqli->connect_error . "\n";
	exit;
} 
else {
    $user_query = "
    SELECT * 
    FROM INVENTORY
    WHERE INVENTORY_ID=".$id;

    $q_result = $mysqli->query($user_query);

    if ( !$q_result) {
        echo "Query failed: ". $mysqli->error. "\n";
        exit;
    }
    else if ($q_result->num_rows > 0){
        # Insert new cart with this user
        $row = mysqli_fetch_assoc($q_result);
        echo $row['INVENTORY_ID'];
        echo "
        <h3> Update Item: </h3>
        <form action='stafflogin.php' method='post'>
            <table class='customers'>
            <tr>
                <td>Product Name:</td> <td><input type='text' value='".$row['PRODUCT_NAME']."' name='name'></td>
                <td>Amount:</td> <td><input type='number' value='".$row['AMOUNT']."' name='amount'></td>
                <td>Price:</td> <td><input type='number' value='".$row['PRICE']."' name='price' step='0.01'></td>
                <td>Description:</td> <td><input type='text' value='".$row['PRODUCT_DESC']."' name='description'></td>
            </tr>
            </table>
            <input type='submit' name='action_type' value='Update Item in Inventory'>
            <input type='hidden' name='update_id' value='".$row['INVENTORY_ID']."'>
        </form>
        ";
    }

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
        input {
            padding: 10px;
        }
        </style>
        </head>
        <body>
    
        <ul>
        <li><a class='active' href='/milestone3.php'>Home</a></li>
        <li><a href='/shopping.php'>Shopping</a></li>
        <li><a href='/cart.php'>My Cart</a></li>
        <li><a href='/orders.php'>My Orders</a></li>
        <li><a href='/stafflogin.php'>Staff Functions</a></li>
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
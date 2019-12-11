<?php

$host = 'localhost';//enter hostname
$userName = 'root';//enter user name of DB
$Pass = 'pwd'; //enter password
$DB = 'TOYS_ORDERS'; //Enter database name
$mysqli = new mysqli($host, $userName,$Pass,$DB);
setupHTML("Promotions Management");

if ($mysqli->connect_errno) {
	echo "Could not connect to database \n";
	echo "Error: ". $mysqli->connect_error . "\n";
	exit;
} 
else {
    $user_query = "
    SELECT * 
    FROM INVENTORY";

    $q_result = $mysqli->query($user_query);

    if ( !$q_result) {
        echo "Query failed: ". $mysqli->error. "\n";
        exit;
    }
    else if ($q_result->num_rows > 0){
        # Insert new cart with this user
        echo "<h3> Update Items: </h3>
        <table id='customers'>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Promotions</th>
            <th>Submit Changes</th>
        ";
        while($data= mysqli_fetch_assoc($q_result)){
            $user_query = "
            SELECT AMOUNT 
            FROM PROMOTIONS
            WHERE INVENTORY_ID=".$data["INVENTORY_ID"];
            $query_result = $mysqli->query($user_query);
            $promotion = "None";
            if ($query_result->num_rows > 0){
                $row = mysqli_fetch_assoc($query_result);
                $promotion = $row["AMOUNT"];
            }
            echo "
            <form action='stafflogin.php' method='post'>
                <tr>
                    <td><input type='text' value='".$data['PRODUCT_NAME']."' name='name'></td>
                    <td><input type='number' value='".$data['AMOUNT']."' name='amount'></td>
                    <td><input type='number' value='".$data['PRICE']."' name='price' step='0.01'></td>
                    <td><input type='number' value='".$promotion."' name='promotions' step='0.01'></td>
                    <td>
                    <input type='submit' name='action_type' value='Update Promotions'>
                    <input type='hidden' name='update_id' value='".$data['INVENTORY_ID']."'>
                    </td>
                </tr>
            </form>
            ";
        }
        echo "
        </table>";
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

?>
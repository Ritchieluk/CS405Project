<?php

buildHTML();

$host = 'localhost';//enter hostname
$userName = 'root';//enter user name of DB
$Pass = 'pwd'; //enter password
$DB = 'TOYS_ORDERS'; //Enter database name
$mysqli = new mysqli($host, $userName,$Pass,$DB);

if ($mysqli->connect_errno) {
	echo "Could not connect to database \n";
	echo "Error: ". $mysqli->connect_error . "\n";
	exit;
} 
else {
	//echo "Checking if user ". $username. " exists </br>";

    // Let's write the query and store it in a variable
    $user_query = "
    SELECT INVENTORY_ID, ORDER_STATUS, QUANTITY, PRICE, PRODUCT_NAME, AMT
    FROM (
        SELECT * FROM INVENTORY
        LEFT JOIN (
            SELECT INVENTORY_ID AS INV_ID, AMOUNT AS AMT
            FROM PROMOTIONS
        ) AS P
        ON INVENTORY.INVENTORY_ID=P.INV_ID) AS IP, 
        (
        SELECT INVENTORY_ID AS I_ID, ORDER_STATUS, QUANTITY
        FROM ORDERS
        WHERE PERSON_ID IN (
            SELECT PERSON_ID 
            FROM PEOPLE
            WHERE (USERNAME = '".$_COOKIE['current_user']."')
            )
        ) AS ORDER_INFO
    WHERE IP.INVENTORY_ID = ORDER_INFO.I_ID";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows > 0) {
        echo "<h2>Orders for user '".$_COOKIE["current_user"]."'</h2>";
        buildTable($q_result);
	}
	else {
		echo "<h3> You haven't made any orders, please check back once you have! </h3>";
	}
	
}
function buildTable($query_results){
    echo "
    <div>
        <table id='customers' cellpadding='5'>
            <th>Product</th>
            <th>Status</th>
            <th>Quantity</th>
            <th>Price Paid</th>
            <th>Product Page</th>
    ";
    while($row = mysqli_fetch_assoc($query_results)){
        addItem($row);
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
function addItem($data){
    if ($data["AMT"] != null){
        $data["PRICE"] = $data["PRICE"] * (100 - $data["AMT"]) / 100;
        $data["PRICE"] = strval($data["PRICE"]) . " (Had Discount of " . strval($data["AMT"]) . "%)";
    }
    echo "
    <form action='productpage.php' method='post'>
    <tr>
        <td>".$data["PRODUCT_NAME"]." </td>
        <td>".$data["ORDER_STATUS"]." </td>
        <td>".$data["QUANTITY"]."</td>
        <td>$".$data["PRICE"]."</td> 
        <td><input type='submit' value='View Product Page'></td>
    </tr>
    <input type='hidden' name='name' value='".$data["INVENTORY_ID"]."'>
    </form>
    ";
}


function buildHTML(){
    echo "<style>
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

    <h1>The Ultimate Toy Shopping Experience</h1>


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
    </style>";
}
?>

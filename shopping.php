<?php
setupHTML("");

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
    echo "<h3> Our Product Line up </h3>";
	$user_query = "
	SELECT INVENTORY_ID, PRODUCT_NAME, PRICE 
	FROM INVENTORY
	WHERE (AMOUNT > 0)";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($q_result)){
            addItem($row["INVENTORY_ID"],$row["PRODUCT_NAME"], $row["PRICE"]);
            //echo "<span> name: ". $row["PRODUCT_NAME"]. " - Price: ". $row["PRICE"] ."</span>";
        }
	}
	else {
		echo "<h3> Our Inventory is currently empty, please check back some other time </h3>";
	}
	
}

function addItem($id, $name, $price){
    echo "
    <div>
        <form action='productpage.php' method='post'>
        <table id='customers' cellpadding='5'>
            <td>".$name." </td>
            <td>$".$price." </td>
            <td><input type='submit' value='View Product Page'></td>
        </table>
        <input type='hidden' name='name' value='".$id."'>
        
        </form>
    </div>
    ";
}

function setupHTML($input){
    echo "
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

    <h1>Welcome to the Ultimate Toy Shopping Experience</h1>

    ".$input."

    </body>
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
?>
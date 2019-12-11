<?php
$ids = array(1,2,3);
$new_id;
if($_POST["cart"] != null){
	$new_id = $_POST["cart"];
	$_POST["cart"] = null;
}

setupHTML();

# Insert ID Into User's Cart

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
	# Insert ID Into User's Cart\
	if($new_id != null){
		$user_query = "
		SELECT * 
		FROM CART
		WHERE PERSON_ID IN (
			SELECT PERSON_ID 
				FROM PEOPLE
				WHERE (USERNAME = '".$_COOKIE['current_user']."')
			)";

		$q_result = $mysqli->query($user_query);
		// Execute the query and check for error
		if ( !$q_result) {
			echo "Query failed: ". $mysqli->error. "\n";
			exit;
		}
		else if ($q_result->num_rows == 0){
			# Insert new cart with this user
			$user_query = "
			INSERT 
			INTO CART (INVENTORY_ID, QUANTITY, PERSON_ID)
			VALUES (".$new_id.",1,".$_COOKIE['current_user'].")";
			$q_result = $mysqli->query($user_query);
		}
		else if ($q_result->num_rows > 0){
			# check if item in cart
			$user_query = "
				SELECT * 
				FROM CART
				WHERE PERSON_ID IN (
					SELECT PERSON_ID 
						FROM PEOPLE
						WHERE (USERNAME = '".$_COOKIE['current_user']."')
					) AND INVENTORY_ID =".$new_id;
			$q_result = $mysqli->query($user_query);
			if ($q_result->num_rows == 0){
				# Insert new cart with this user
				$user_query = "
				INSERT 
				INTO CART (INVENTORY_ID, QUANTITY, PERSON_ID)
				VALUES (".$new_id.",1,(
					SELECT PERSON_ID 
					FROM PEOPLE
					WHERE (USERNAME = '".$_COOKIE['current_user']."')
					)
				)";
				$q_result = $mysqli->query($user_query);
			}
			else {
				# Increment quantity 
				$user_query = "
				UPDATE CART
				SET QUANTITY = QUANTITY + 1
				WHERE (INVENTORY_ID=".$new_id." AND PERSON_ID IN (
					SELECT PERSON_ID 
					FROM PEOPLE
					WHERE (USERNAME = '".$_COOKIE['current_user']."')
					)
				)";
				$q_result = $mysqli->query($user_query);
			}
		}
	}
	# Get Total Cart Contents
	echo "<h2> Cart for user '".$_COOKIE["current_user"]."'</h2>";
	$user_query = "
	SELECT INVENTORY_ID, AMOUNT, PRICE, PRODUCT_NAME, Q
	FROM INVENTORY 
	RIGHT JOIN (
		SELECT INVENTORY_ID AS I_ID, QUANTITY AS Q 
		FROM CART
		WHERE PERSON_ID IN (
			SELECT PERSON_ID 
				FROM PEOPLE
				WHERE (USERNAME = '".$_COOKIE['current_user']."')
		)
	) AS C
	ON INVENTORY.INVENTORY_ID=C.I_ID";
	$q_result = $mysqli->query($user_query);
	if ($q_result->num_rows > 0) {
		buildTable($q_result);
		addOrderForm();
	}
	else {
		echo "<h3> Your cart is currently empty, add items to view them here! </h3>";
	}
}

function buildTable($query_results){
    echo "
    <div>
        <table id='customers' cellpadding='5'>
            <th>Product</th>
            <th>In Stock</th>
            <th>In Cart</th>
            <th>Price</th>
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
	$host = 'localhost';//enter hostname
	$userName = 'root';//enter user name of DB
	$Pass = 'pwd'; //enter password
	$DB = 'TOYS_ORDERS'; //Enter database name
	$mysqli = new mysqli($host, $userName,$Pass,$DB);
	$user_query = "
	SELECT AMOUNT 
	FROM PROMOTIONS
	WHERE INVENTORY_ID=".$data["INVENTORY_ID"];
	$q_result = $mysqli->query($user_query);
	
    if ($q_result->num_rows > 0){
		$row = mysqli_fetch_assoc($q_result);
        $data["PRICE"] = $data["PRICE"] * (100 - $row["AMOUNT"]) / 100;
        $data["PRICE"] = strval($data["PRICE"]) . " (Has Discount of " . strval($row["AMOUNT"]) . "%)";
    }
    echo "
    <form action='productpage.php' method='post'>
    <tr>
        <td>".$data["PRODUCT_NAME"]." </td>
        <td>".$data["AMOUNT"]." </td>
        <td>".$data["Q"]."</td>
        <td>$".$data["PRICE"]."</td> 
        <td><input type='submit' value='View Product Page'></td>
    </tr>
    <input type='hidden' name='name' value='".$data["INVENTORY_ID"]."'>
    </form>
    ";
}

function addOrderForm(){
	echo "
	<form action='createOrder.php' method='post'>
	<input type='submit' value='Purchase Items in Cart'>
	<input type='hidden' name='customer_id' value='".$_COOKIE['current_user']."'>
	</form>
	";
}

function setupHTML(){
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
    <body>
    <Title>Toy Store</Title>

    <h1>The Ultimate Toy Shopping Experience</h1>

    

    </body>
    <style>
    
        .customers {
        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
        }

        .customers td, #customers th {
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

</body>
</html>

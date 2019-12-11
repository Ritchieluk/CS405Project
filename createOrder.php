<?php
$id = $_POST["customer_id"];

$host = 'localhost';//enter hostname
$userName = 'root';//enter user name of DB
$Pass = 'pwd'; //enter password
$DB = 'TOYS_ORDERS'; //Enter database name
$mysqli = new mysqli($host, $userName,$Pass,$DB);


setupHTML();

if ($mysqli->connect_errno) {
	echo "Could not connect to database \n";
	echo "Error: ". $mysqli->connect_error . "\n";
	exit;
} 
else {
    $user_query = "
    SELECT COUNT(ORDER_ID)
    FROM ORDERS
    ";
    $order_id;
    $q_result = $mysqli->query($user_query);
    if ( !$q_result) {
        echo "INSERT Query failed: ". $mysqli->error. "\n";
        exit;
    }
    else {
        $row = mysqli_fetch_assoc($q_result);
        $order_id = $row["COUNT(ORDER_ID)"]; 
    }
    $user_query = "
    SELECT PERSON_ID
    FROM PEOPLE
    WHERE USERNAME='".$id."'";

    $q_result = $mysqli->query($user_query);
    if ( !$q_result) {
        echo "PEOPLE Query failed: ". $mysqli->error. "\n";
        exit;
    }
    $row = mysqli_fetch_assoc($q_result);
    $user_id = $row["PERSON_ID"];
    $user_query = "
    SELECT INVENTORY_ID, QUANTITY
    FROM CART
    WHERE PERSON_ID=".$user_id;

    $q_result = $mysqli->query($user_query);

    if ( !$q_result) {
        echo "Query failed: ". $mysqli->error. "\n";
        exit;
    }
    else if ($q_result->num_rows > 0){
        
        while($row = mysqli_fetch_assoc($q_result)){
            $user_query = "
            INSERT 
            INTO ORDERS (ORDER_ID, INVENTORY_ID, PERSON_ID, ORDER_STATUS, QUANTITY)
            VALUES (".$order_id.", ".$row["INVENTORY_ID"].", ".$user_id.",'pending',".$row["QUANTITY"].")";

            $query_result = $mysqli->query($user_query);
            if ( !$query_result) {
                echo "INSERT Query failed: ". $mysqli->error. "\n";
                exit;
            }

        }
        $user_query = "
        DELETE
        FROM CART
        WHERE PERSON_ID=".$user_id;

        $q_result = $mysqli->query($user_query);

        if ( !$q_result) {
            echo "DELETE Query failed: ". $mysqli->error. "\n";
            exit;
        }
        echo "
        <h3>Your order was successfully submitted!</h3>
        <form action='milestone3.php' method='post'>
        <input type='submit' value='Return Home'>
        </form>";
    }
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
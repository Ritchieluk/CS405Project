<?php
$ids = array(1,2,3);
setcookie("test", serialize($ids), time() + 3600, '/');
?>
<html>
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

<?php
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
else if (count($_COOKIE) > 0) {
    echo "Cookies are enabled.";
    $data = unserialize($_COOKIE['test'], ["allowed_classes" => false]);
    foreach($data as $result) {
        echo $result, '<br>';
        $user_query = "
        SELECT PRODUCT_NAME, PRICE 
        FROM INVENTORY
        WHERE (INVENTORY_ID = ".$result.")";
        
        $q_result = $mysqli->query($user_query);
        // Execute the query and check for error
        if ( !$q_result) {
            echo "Query failed: ". $mysqli->error. "\n";
            exit;
        }
        if ($q_result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($q_result)){
                #echo "<span> name: ". $row["AMOUNT"]. " - Price: ". $row["PRICE"] ."</span>";
                #echo "<span> Description: ". $row["PRODUCT_DESC"]."</span>";
                echo "Name: ".$row["PRODUCT_NAME"]." Price: ".$row["PRICE"];
                //echo "<span> name: ". $row["PRODUCT_NAME"]. " - Price: ". $row["PRICE"] ."</span>";
            }
        }
        else {
            echo "<h3> Our Inventory is currently empty, please check back some other time </h3>";
        }
    }
} else {
    echo "Cookies are disabled.";
}
?>

</body>
</html>
<?php

setupHTML("Stats Screen");
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
	$user_query = "
	SELECT * FROM SALES_STATISTICS";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		exit;
	}
	if ($q_result->num_rows > 0) {
        echo"
            <table id='customers'>
                <th>Inventory ID</th>
                <th>Weekly Sales</th>
                <th>Monthly Sales</th>
                <th>Yearly Sales</th>
            </table>
        ";
        while($row = mysqli_fetch_assoc($q_result)){
            addItem($row["INVENTORY_ID"],$row["WEEK_SALES"], $row["MONTH_SALES"], $row["YEAR_SALES"]);
        }
	}
	else {
		echo "<h3> No Stats have been passed to Sales_Statistics. Wait for weekly update. </h3>";
    }
}
function addItem($id, $week, $month, $year) {
    echo "
    <div>
        <table id='customers'>
            <td>".$id." </td>
            <td>".$week." </td>
            <td>".$month." </td>
            <td>".$year." </td>
        </table>
    </div>
    ";
}
    
function setupHTML($input){
	echo "
    <body>
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
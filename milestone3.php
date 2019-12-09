<?php
// This is a basic script showing how to connect to a local MySQL database
// and execute a query

// First, let's get our variables from the previous page
// remember, we stored them in a "post" variable called "professor"
$username = $_POST["username"];
$password = $_POST["password"];
setcookie("current_user", $username, time()+3600, '/');
if(($username == null || $password == null) && !isset($_COOKIE["current_user"])){
	header("Location: ./homepage.php");
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
	//echo "Checking if user ". $username. " exists </br>";

	// Let's write the query and store it in a variable
	$user_query = "
	SELECT USERNAME, PW 
	FROM PEOPLE 
	WHERE (USERNAME = '$username' AND PW = '$password')";
	
	$q_result = $mysqli->query($user_query);
	// Execute the query and check for error
	if ( !$q_result) {
		echo "Query failed: ". $mysqli->error. "\n";
		setcookie("current_user", "", time()-3600);
		exit;
	}
	if ($q_result->num_rows > 0) {
		$resulting_string = "<br> Welcome back user: ". $username. "<br \>";
		startShoppingForm($resulting_string);
	}
	else {
		$insert_user = "INSERT INTO PEOPLE(PERSON_TYPE, USERNAME, PW) VALUES (1, '$username', '$password')";
		$q_result = $mysqli->query($insert_user);
		echo $q_result;
		$resulting_string = "<br> Welcome, ". $username. "! <br \> <br>You've been registered <br \>";
		startShoppingForm($resulting_string);
		
	}
	
}
function startShoppingForm($input){
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

	<h2>". $input ."</h2>
	<hr>
	<form action='shopping.php' method='post'>
	<input type='submit' value='Start Shopping'>
	</form>
	<br>
	<hr>
	<br>
	<form action='stafflogin.php' method='post'>
	<h4>Staff Login</h4>
	<table>
	<td>Username:</td> <td><input type='text' name='username'></td>
	<td>Password:</td> <td><input type='password' name='password'></td>
	</table>
	<input type='submit'>
	</form>
	
	
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

<?php

setupHTML("Update Inventory Screen");

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
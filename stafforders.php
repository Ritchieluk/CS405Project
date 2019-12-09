<?php

setupHTML("");

$product_id = $_POST["name"];

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
    // Let's write the query and store it in a variable
    
    $user_query = "
    SELECT * 
    FROM ORDERS";
    
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
            buildOrderScreen($row["ORDER_ID"],$row["INVENTORY_ID"],$row["PERSON_ID"], $row["ORDER_STATUS"], $row["QUANTITY"]);
            //echo "<span> name: ". $row["PRODUCT_NAME"]. " - Price: ". $row["PRICE"] ."</span>";
        }
    }
    else {
        echo "<h3> No orders at all. The company is failing. Eat the CEO. </h3>";
    }
}
function buildOrderScreen($order_id, $inventory_id, $person_id, $order_status, $quantity) {
    echo "
    <div>
        <form action='stafforders.php' method='post'>
        <table id='orders' cellpadding='5'>
            <td>".$order_id." </td>
            <td>".$inventory_id." </td>
            <td>".$person_id." </td>
            <td><div contenteditable>".$order_status." </diV></td>
            <td>".$quantity." </td>
            <td><input type='submit' value='View Product Page'></td>
            <td>
                <button id='submitButton'>
                    Save Status
                </button>
            </td>
        </table>
        <input type='hidden' name='name' value='".$id."'>
        
        </form>
    </div>
    ";
}

function setupHTML($input) {
    echo "
    <body>
    <Title>Toy Store</Title>

    <h1>Welcome to the Ultimate Toy Shopping Experience</h1>

    ".$input."

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
?>

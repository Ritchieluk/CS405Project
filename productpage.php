<?php
if (!isset($_POST['cart'])){
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
        //echo "Checking if user ". $username. " exists </br>";

        // Let's write the query and store it in a variable
        
        $user_query = "
        SELECT * 
        FROM INVENTORY
        WHERE (INVENTORY_ID = ".$product_id.")";
        
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
                setupHTML(buildPurchaseScreen($row["INVENTORY_ID"],$row["PRICE"],$row["PRODUCT_NAME"], $row["AMOUNT"], $row["PRODUCT_DESC"]));
                //echo "<span> name: ". $row["PRODUCT_NAME"]. " - Price: ". $row["PRICE"] ."</span>";
            }
        }
        else {
            echo "<h3> Our Inventory is currently empty, please check back some other time </h3>";
        }
        
    }
}
else {
    addCookies();
}

function addCookies(){
    #echo "Adding cookies";
    if(!isset($_COOKIE[$_COOKIE['current_user']])){
        $ids = array($_POST['cart']);
        setcookie($_COOKIE['current_user'], serialize($ids), time()+3600);
    }
    else {
        $data = unserialize($_COOKIE['current_user'], ["allowed_classes" => false]);
        setcookie($_COOKIE['current_user'], "", time()-3600);
        array_push($data, $_POST['cart']);
        setcookie($_COOKIE['current_user'], serialize($data), time()+3600);
    }
    $_POST = array();
}

function buildPurchaseScreen($id, $price, $name, $quantity, $description){
    return "<div class='card'>
    <form action = '' method='post'>
        <img src='".$id.".jpg' alt='Denim Jeans' style='width:100%'>
        <h1>".$name."</h1>
        <p class=".$price.">$19.99</p>
        <p>".$description."</p>
        <p><button type='submit' name='cart' value=".$id.">Add to Cart - (Quantity: ".$quantity.")</button></p>
    </form>
  </div>
  <style>
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 300px;
    margin: auto;
    text-align: center;
    font-family: arial;
  }
  
  .price {
    color: grey;
    font-size: 22px;
  }
  
  .card button {
    border: none;
    outline: 0;
    padding: 12px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
  }
  
  .card button:hover {
    opacity: 0.7;
  }
  </style>";

}

function setupHTML($input){
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

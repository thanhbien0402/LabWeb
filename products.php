<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "OnlineStore";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an AJAX request has been made for product details
if (isset($_GET['ajaxRequest']) && isset($_GET['productId'])) {
    $productId = intval($_GET['productId']);
    $sql = "SELECT description FROM products WHERE productID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $response = [];
    if ($row = $result->fetch_assoc()) {
        $response = $row;
    } else {
        $response = ['error' => 'Product not found.'];
    }
    $stmt->close();
    
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

* {
  box-sizing: border-box;
}

/* Create a column layout with Flexbox */
.row {
  display: flex;
}

/* Left column (menu) */
.left {
  flex: 30%;
  padding: 15px 0;
}

.left h2 {
  padding-left: 8px;
}

/* Right column (page content) */
.right {
  flex: 70%;
  padding: 15px;
}

/* Style the search box */
/* #mySearch {
  width: 100%;
  font-size: 18px;
  padding: 11px;
  border: 1px solid #ddd;
} */

input[type=text] {
  width: 100%;
  font-size: 18px;
  padding: 11px;
  border: 1px solid #ddd;
  background-image: url('searchicon.png');
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
}

input[type=text]:focus {
  width: 100%;
}
/* Style the navigation menu inside the left column */
#myMenu {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myMenu li a {
  padding: 12px;
  text-decoration: none;
  color: black;
  display: block
}

#myMenu li a:hover {
  background-color: #eee;
}

/* Pagination */
.center {
  text-align: center;
  margin-top: 5cm;
}

.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .2s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination a.active {
  background-color: #4a8fe7;
  color: white;
  border: 1px solid #4a8fe7;;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
</head>
<body>

<div class="row">
  <div class="left" style="background-color:#bbb;">
    <h2>Product Category</h2>
    <!-- <button type="button" class="navbar-toggle">☰</button> -->
    <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search..." title="Type in a category">
    <ul id="myMenu">
      <?php
      $sql = "SELECT productID, productName FROM products";
      $result = $conn->query($sql);

      if ($result->num_rows > 3) {
          while ($row = $result->fetch_assoc()) {
              echo '<li><a href="#" data-product-id="' . $row['productID'] . '">' . htmlspecialchars($row['productName']) . '</a></li>';
          }
      } else {
          echo "<li>No products found.</li>";
      }
      ?>
    </ul>
  </div>
  
  <div class="right" style="background-color:#ddd;">
    <h2>Product Description</h2>
    <div id="productDetails"></div>
  </div>
</div>

<script>
function myFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("mySearch");
  filter = input.value.toUpperCase();
  ul = document.getElementById("myMenu");
  li = ul.getElementsByTagName("li");
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
    li[i].style.display = "none";
    }
  }
}

document.addEventListener('DOMContentLoaded', function() {
    var productLinks = document.querySelectorAll('#myMenu a');
    productLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var productId = this.dataset.productId;
            fetchProductDetails(productId);
        });
    });

    function fetchProductDetails(productId) {
        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    var response = JSON.parse(httpRequest.responseText);
                    if (response.error) {
                        document.getElementById('productDetails').textContent = response.error;
                    } else {
                        document.getElementById('productDetails').textContent = response.description;
                    }
                }
            }
        };
        httpRequest.open('GET', 'products.php?ajaxRequest=true&productId=' + productId, true);
        httpRequest.send();
    }
});
</script>

</body>
</html>
<?php
$conn->close();
?>

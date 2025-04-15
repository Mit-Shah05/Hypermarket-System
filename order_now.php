<?php
// Include your database connection
include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartItems = json_decode($_POST['cartItems'], true);
    $paymentMethod = $_POST['paymentMethod'];
    $customerId = 1; // Replace with logged-in session ID in production
    $orderDate = date('Y-m-d');
    $orderStatus = "Pending";
    $totalAmount = 0;

    // Check if customer exists
    $checkCustomer = $conn->prepare("SELECT CustomerID FROM customer WHERE CustomerID = ?");
    $checkCustomer->bind_param("i", $customerId);
    $checkCustomer->execute();
    $checkCustomer->store_result();

    if ($checkCustomer->num_rows == 0) {
        die("Error: Customer ID $customerId does not exist in the customer table.");
    }
    $checkCustomer->close();

    // Calculate total amount
    foreach ($cartItems as $item) {
        $totalAmount += $item['price'];
    }

    // Insert into Orders table
    $stmt = $conn->prepare("INSERT INTO Orders (CustomerID, OrderDate, PaymentMethod, OrderStatus, TotalAmount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $customerId, $orderDate, $paymentMethod, $orderStatus, $totalAmount);

    if (!$stmt->execute()) {
        die("Order insert failed: " . $stmt->error);
    }

    $orderID = $stmt->insert_id; // Get the new OrderID
    $stmt->close();

    // Insert items into OrderDetails
$stmt = $conn->prepare("INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)");

foreach ($cartItems as $item) {
    $productName = trim(explode('Rs', $item['name'])[0]);
    $price = $item['price'];
    $quantity = 1; // or $item['quantity'] if you're capturing it

    // Lookup ProductID from ProductName
    $productStmt = $conn->prepare("SELECT ProductID FROM product WHERE ProductName = ?");
    $productStmt->bind_param("s", $productName);
    $productStmt->execute();
    $productStmt->bind_result($productID);

    if ($productStmt->fetch()) {
        $stmt->bind_param("iiid", $orderID, $productID, $quantity, $price);
        if (!$stmt->execute()) {
            echo "Failed to insert OrderDetail for $productName: " . $stmt->error . "<br>";
        }
    } else {
        echo "Product not found: $productName<br>";
    }

    $productStmt->close();
}
    $stmt->close();

    echo "✅ Order placed successfully! Order ID: $orderID";
}
?>

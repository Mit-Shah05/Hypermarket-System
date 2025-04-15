<?php
// Include DB connection
include('db_connect.php');

if (isset($_POST['submit'])) {
    // Collect customer data (basic sanitization)
    $first_name = htmlspecialchars($_POST['first_name']);
    $middle_name = htmlspecialchars($_POST['middle_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $street_no = htmlspecialchars($_POST['street_no']);
    $street_name = htmlspecialchars($_POST['street_name']);
    $state = htmlspecialchars($_POST['state']);
    $pincode = htmlspecialchars($_POST['pincode']);
    $membership_type = htmlspecialchars($_POST['membership_status']); // e.g. 'Gold', 'Silver'

    // Insert into customer table
    $sql = "INSERT INTO customer (
        FirstName, MiddleName, LastName, Email, PhoneNumber, Address,
        StreetNo, StreetName, State, Pincode, MembershipStatus
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $first_name, $middle_name, $last_name, $email, $phone, $address,
        $street_no, $street_name, $state, $pincode, $membership_type);

    if ($stmt->execute()) {
        // Get inserted customer ID
        $customer_id = $stmt->insert_id;

        // Membership values
        $join_date = date('Y-m-d');
        $expiry_date = date('Y-m-d', strtotime('+1 year'));
        $membership_status = 'Active';
        $points = 0;

        // Insert into membership table
        $sql_membership = "INSERT INTO membership (
            MembershipType, JoinDate, ExpiryDate, MembershipStatus, PointsAccumulated, CustomerID
        ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt2 = $conn->prepare($sql_membership);
        $stmt2->bind_param("ssssii", $membership_type, $join_date, $expiry_date, $membership_status, $points, $customer_id);

        if ($stmt2->execute()) {
            echo "<script>alert('Signed in successfully! Membership Created.'); window.location.href='index.html';</script>";
        } else {
            echo "Error inserting membership: " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        echo "Error inserting customer: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Form not submitted.";
}
?>

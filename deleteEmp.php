<?php
    include('connection.php');

    // Check if ID is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM `empdetails` WHERE `id` = '$id'";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo "Employee Detail with ID = {$id} deleted successfully";
            header('Location: displayDetails.php?success=deleted');
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
mysqli_close($conn);
?>
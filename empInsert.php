<?php
    include('connection.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $empId = $_POST['empId'];
        $empName = $_POST['empName'];
        $empRole = $_POST['empRole'];
        $empPhone = $_POST['empPhone'];
        $empDOJ = $_POST['empDOJ'];
        if( !empty($empId) && 
            !empty($empName) &&
            !empty($empRole) && 
            !empty($empPhone) && 
            !empty($empDOJ))
        {
            $sqlIn = "INSERT INTO `empdetails`(`id`,`empname`,`emprole`,`empphone`,`empdoj`) VALUES ('$empId', '$empName', '$empRole', '$empPhone', '$empDOJ')";
                if(mysqli_query($conn, $sqlIn)){
                    // Redirect to emp_form.php with success parameter
                    header('Location: emp_form.php?success=true');
                    exit();
                } 
                
                else {
                    // Redirect to emp_form.php with an error message
                    $error = mysqli_error($conn); 
                    header('Location: emp_form.php?success=false');
                    exit();
                    }
        }

        else {
            // Redirect back with an error message
            header('Location: emp_form.php?error=emptyfields');
            exit();
    }
}

    mysqli_close($conn);

?>
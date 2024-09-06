
<?php
    include('connection.php');
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `empdetails` WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if (!$result) {
            echo "Error executing query: " . mysqli_error($conn);
        } else {
            // Check if the query returned any data
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "No record found with ID: $id";
            }
        }
    }

        // Clear fields if there is an error with empty fields
        if (isset($_GET['error']) && $_GET['error'] == 'emptyfields') {
            $row = [
                'id' => $id,
                'empname' => '',
                'emprole' => '',
                'empphone' => '',
                'empdoj' => ''
            ];
        }
?>

<?php

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $updateId = $_POST['updateId'];
            $updateName = $_POST['updateName'];
            $updateRole = $_POST['updateRole'];
            $updatePhone = $_POST['updatePhone'];
            $updateDOJ = $_POST['updateDOJ'];
            if( !empty($updateId) && 
                !empty($updateName) &&
                !empty($updateRole) && 
                !empty($updatePhone) && 
                !empty($updateDOJ))
            {
                $sqlUp = "UPDATE `empdetails` SET `empname` = '$updateName',`emprole` = '$updateRole', `empphone` = '$updatePhone', `empdoj` = '$updateDOJ' WHERE `id` = '$updateId'";
                    if(mysqli_query($conn, $sqlUp)){
                        header('Location: displayDetails.php?success=true');
                        exit();
                } 
                    
            else {
                $error = mysqli_error($conn); 
                header('Location: updateDetails.php?success=false');
                exit();
            }
    }

    else {
        header('Location: updateDetails.php?error=emptyfields&id=' . urlencode($updateId));
        exit();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>My First CRUD project</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">MyCRUD</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>


    <!-- Display a success alert if success=true is in the URL -->

    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Employee details have been updated successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- In case of empty field being submitted-->

    <?php if (isset($_GET['error']) && $_GET['error'] == 'emptyfields'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> All fields are required. Please fill in all details.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- Display an error alert if success=false is in the URL -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'false'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Could not insert employee details.
        <?php if (isset($_GET['error'])) echo "Error: " . htmlspecialchars($_GET['error']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- Form-->

    <div class="container" my-4 mb-2>
        <h2>Update Employee's Details</h2>
        <form action="updateDetails.php" method="post" id="employeeForm">
            <div class="mb-3">
                <label for="updateId" class="form-label">ID</label>
                <input type="text" class="form-control" id="updateId" name="updateId" aria-describedby="emailHelp" value="<?php echo $row['id'];?>" placeholder="00000">
            </div>
            <div class="mb-3">
                <label for="updateName" class="form-label">Employee's Name</label>
                <input type="text" class="form-control" id="updateName" name="updateName" aria-describedby="emailHelp" value="<?php echo isset($row['empname']) ? htmlspecialchars($row['empname']) : ''; ?>" placeholder="Employee's Name">
            </div>
            <div class="mb-3">
                <label for="updateRole" class="form-label">Role</label>
                <input type="text" class="form-control" id="updateRole" name="updateRole" aria-describedby="emailHelp" value="<?php echo isset($row['emprole']) ? htmlspecialchars($row['emprole']) : ''; ?>" placeholder="Programmer">
            </div>
            <div class="mb-3">
                <label for="updatePhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="updatePhone" name="updatePhone" aria-describedby="emailHelp" value="<?php echo isset($row['empphone']) ? htmlspecialchars($row['empphone']) : ''; ?>" placeholder="+CCC-XXXXXXXXXX">
            </div>
            <div class="mb-3">
                <label for="updateDOJ" class="form-label">Date of Joining</label>
                <input type="text" class="form-control" id="updateDOJ" name="updateDOJ" aria-describedby="emailHelp" value="<?php echo isset($row['empdoj']) ? htmlspecialchars($row['empdoj']) : ''; ?>" placeholder="YYYY-MM-DD HH:MM:SS">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
            <!-- <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button> -->
        </form>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

        <script>
            function resetForm() {
            document.getElementById('updateName').value = '';
            document.getElementById('updateRole').value = '';
            document.getElementById('updatePhone').value = '';
            document.getElementById('updateDOJ').value = '';
}

        </script>
        <script>
    // Handle alert dismissal
    $(document).ready(function() {
        $('.alert').on('closed.bs.alert', function () {
            // Update URL after alert is closed
            history.pushState(null, '', 'updateDetails.php');
        });
    });
    </script>

</body>
</html>
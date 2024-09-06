<?php
  include('connection.php');
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

  <link rel="stylesheet" href="//cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
  <script src="//cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
  <style>
    .main-container {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .main-container .heading {
      margin: 15px 0;
    }

    .table-box {
      width: 80%;
    }

    .myBtn,
    .myBtn:hover {
      color: white;
      text-decoration: none;
    }

    #addBtn{
      position: absolute;
      left: 10%;
      margin-top: 50px;
      width: 100px;
    }
  </style>

  <title>Details of the Emploeyees</title>
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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
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

  <!-- Display an error alert if error = emptyfields is in the URL -->
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


  <!-- Display a success alert if a record is deleted -->
  <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Deleted!</strong> Employee details have been deleted successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php endif; ?>

  <div class="main-container">
    <div class="heading" my-4>
      <h3>Details of the Emploeyees:</h3>
    </div>

    <div class="table-box">
      <table id="myTable" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <th>SN</th>
            <th>ID</th>
            <th>NAME</th>
            <th>ROLE</th>
            <th>PHONE</th>
            <th>DATE OF JOINING</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sno = 0; 
            $getData = "SELECT * FROM  `empdetails` ORDER BY `id` ASC";
            $result = mysqli_query($conn, $getData);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $sno++;
                echo "
                <tr>
                  <td>$sno</td>
                  <td>{$row['id']}</td>
                  <td>{$row['empname']}</td>
                  <td>{$row['emprole']}</td>
                  <td>{$row['empphone']}</td>
                  <td>{$row['empdoj']}</td>
                  <td>
                    <button class='btn btn-success'><a href='updateDetails.php?id={$row['id']}' class='myBtn'>Edit</a></button>
                    <button class='btn btn-danger'><a href='deleteEmp.php?id={$row['id']}' class='myBtn'>Delete</a></button>
                  </td>
                </tr>";
              }
            }
            ?>
        </tbody>

      </table>
    </div>
  </div>

  <div class="main-container">
    <button class='btn btn-success' id='addBtn'>
      <a href='emp_form.php' class='myBtn'>New Entry</a>
    </button>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
  <script>
    document.getElementById('addBtn').addEventListener('click', (evt) => {
      window.location.href = 'emp_form.php';
    })
  </script>

  <script>
    let table = new DataTable('#myTable');

    $(document).ready(function () {
      $('.alert').on('closed.bs.alert', function () {
        // Update URL after alert is closed
        let url = new URL(window.location.href);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        history.replaceState(null, '', url);
      });
    });
  </script>
</body>

</html>
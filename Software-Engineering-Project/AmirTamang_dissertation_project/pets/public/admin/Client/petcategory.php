<?php
session_start();
// <!-- this code section is for connecting the database -->
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// for adding pet category **************************************************
if (isset($_POST['submit'])) {
  try {
    // prepare the SQL statement
    $stmt = $pdo->prepare('INSERT INTO tbl_pet_category (pet_category_name, user_id) VALUES (:pet_category_name, :user_id)');

    $user_id_value = 1;

    $stmt->bindParam(':pet_category_name', $_POST['pet_category_name']);
    $stmt->bindParam(':user_id', $user_id_value);

    $stmt->execute();

    echo "Pet category added successfully!";
  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }
}

// editing pet category ****************************************************
if (isset($_POST['edit_submit'])) {
  $category_id = $_POST['edit_pet_category_id'];
  $category_name = $_POST['edit_pet_category_name'];

  // check if the category name is not empty
  if (!empty($category_name)) {
    // perform the database update query
    $stmt = $pdo->prepare('UPDATE tbl_pet_category SET pet_category_name = :pet_category_name WHERE pet_category_id = :pet_category_id');
    $stmt->bindParam(':pet_category_name', $category_name, PDO::PARAM_STR);
    $stmt->bindParam(':pet_category_id', $category_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      // successful update
      echo "Successfully updated Pet Category.";
    } else {
      // error handling for the update query
      echo "Error updating category.";
    }
  } else {
    // handle the case where the category name is empty
    echo "Pet Category name cannot be empty.";
  }
}
// fetch data from the database
$stmt = $pdo->query('SELECT * FROM tbl_pet_category');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// deleting pet category ***********************************************
ob_start();

if (isset($_GET['delete_category_id'])) {
  $delete_category_id = $_GET['delete_category_id'];

  // perform the database delete query
  $stmt = $pdo->prepare('DELETE FROM tbl_pet_category WHERE pet_category_id = :delete_category_id');
  $stmt->bindParam(':delete_category_id', $delete_category_id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    // redirect back to the page after successful deletion
    echo "Pet Category has been deleted.";
  } else {
    echo "Error deleting category.";
  }
}

ob_end_flush();

// retrieve and display the pet categories in the table *****************
try {
  $stmt = $pdo->prepare('SELECT * FROM tbl_pet_category');
  $stmt->execute();
  $petCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Store- Manage Pet Category</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light navbar-green">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/index.php" class="brand-link">
        <img src="../dist/img/logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Pet Store</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- dashboard -->
            <li class="nav-item">
              <a href="dashboard.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <!-- pet -->
            <li class="nav-item menu-open">
              <a class="nav-link" style="background-color: #e83e8c; color: white;">
                <i class="nav-icon fas fa-paw"></i>
                <p>Pet<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></span></p>
              </a>
              <ul class="nav nav-treeview">
                <!-- pet category -->
                <li class="nav-item">
                  <a href="petcategory.php" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Pet Category</p>
                  </a>
                </li>
                <!-- pet management -->
                <li class="nav-item">
                  <a href="petmanagement.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Pet Management</p>
                  </a>
                </li>
                <!-- pet category -->
                <li class="nav-item">
                  <a href="productcategory.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product Category</p>
                  </a>
                </li>
                <!-- pet product -->
                <li class="nav-item">
                  <a href="product.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product</p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- management -->
            <li class="nav-item">
              <a class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Management
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <!-- to format in vertical list -->
              <ul class="nav nav-treeview">
                <!-- order -->
                <li class="nav-item">
                  <a href="order.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Order</p>
                  </a>
                </li>
                <!-- user -->
                <li class="nav-item">
                  <a href="user.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User</p>
                  </a>
                </li>
              </ul>
            </li>
            <!-- order detail -->
            <li class="nav-item">
              <a href="orderdetail.php" class="nav-link">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>
                  Order Detail
                </p>
              </a>
            </li>
            <!-- payment -->
            <li class="nav-item">
              <a href="payment.php" class="nav-link">
                <i class="nav-icon fas fa-money-bill-wave"></i>
                <p>
                  Payment
                </p>
              </a>
            </li>

            <!-- logout -->
            <li class="nav-item">
              <a href="../adminlogout.php" class="nav-link" onclick="return confirm('Are you sure you want to logout?');">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <!-- sidebar menu end -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Pet Category</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Pet</a></li>
                <li class="breadcrumb-item active">Category</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Pet Category Data table</h3>
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add" style="margin-left:77%"><i class="fa fa-plus">Add</i>
                  </button>
                  <div class="modal fade" id="add">
                    <div class="modal-dialog modal-sm">

                      <!-- form to add pet category -->
                      <form action="petcategory.php" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Category</label>
                                <input type="text" class="form-control" row="5" id="" name="pet_category_name" placeholder="Enter Category Name..">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> close</button>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-check"></i> submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Display pet categories in the table -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th width="7%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($petCategories as $category) : ?>
                        <tr>
                          <td><?= $category['pet_category_id']; ?></td>
                          <td><?= $category['pet_category_name']; ?></td>

                          <td>
                            <!-- edit button -->
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#update"><i class="fa fa-pencil-alt"></i>
                            </button>

                            <!-- delete button -->
                            <button class="btn btn-danger btn-xs" onclick="deleteCategory(<?= $category['pet_category_id']; ?>)"><i class="fa fa-trash"></i>
                            </button>
                            <!-- pop up message for confirmation-->
                            <script>
                              function deleteCategory(categoryId) {
                                if (confirm("Are you sure you want to delete this category?")) {
                                  window.location.href = "?delete_category_id=" + categoryId;
                                }
                              }
                            </script>

                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <!-- updating pet categories in the table -->
                  <div class="modal fade" id="update">
                    <div class="modal-dialog modal-sm">
                      <form action="petcategory.php" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Update Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">

                              <div class="form-group">
                                <label for="exampleInputEmail2">Pet Category ID</label>
                                <input type="text" class="form-control" row="5" name="edit_pet_category_id" value="<?= $category['pet_category_id']; ?>">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputEmail1">Category</label>
                                <input type="text" id="edit_category_name" name="edit_pet_category_name" placeholder="Enter Category Name.." value="<?= $category['pet_category_name']; ?>">
                              </div>

                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" class="btn btn-primary" name="edit_submit"><i class="fa fa-check"></i> Submit</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                </div>
                <!-- ****************************************************************** -->

                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <!-- footer start -->
    <footer class="main-footer">
      <a class="text-black">Pet Store 2023.</a>
    </footer>
    <!-- footer end -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->

  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>
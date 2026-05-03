<?php
session_start();
// <!-- this code section is for connecting the database -->
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// for adding pet **************************************************
$alertMessage = '';

if (isset($_POST['submit'])) {
  try {
    $user_id_value = 1;

    // checking if a file was uploaded
    if (isset($_FILES['pet_images']) && $_FILES['pet_images']['error'] === UPLOAD_ERR_OK) {
      // a directory to store uploaded files
      $upload_dir = '../../pimg/';
      $upload_file = $upload_dir . basename($_FILES['pet_images']['name']);

      // this code is to get the file extension
      $file_extension = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

      // an array of allowed file extensions
      $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx');

      if (in_array($file_extension, $allowed_extensions)) {
        // to move the uploaded file to the defined directory
        if (move_uploaded_file($_FILES['pet_images']['tmp_name'], $upload_file)) {

          // prepare the SQL statement
          $stmt = $pdo->prepare('INSERT INTO tbl_pet (pet_description, pet_name, pet_category_id, pet_images, pet_price, quantity, discount, user_id) 
                                VALUES (:pet_description, :pet_name, :pet_category_id, :pet_images, :pet_price, :quantity, :discount, :user_id)');

          $stmt->bindParam(':pet_description', $_POST['pet_description']);
          $stmt->bindParam(':pet_name', $_POST['pet_name']);
          $stmt->bindParam(':pet_category_id', $_POST['pet_category_id']);
          $stmt->bindParam(':pet_images', $upload_file);
          $stmt->bindParam(':pet_price', $_POST['pet_price']);
          $stmt->bindParam(':quantity', $_POST['quantity']);
          $stmt->bindParam(':discount', $_POST['discount']);
          $stmt->bindParam(':user_id', $user_id_value);

          if ($stmt->execute()) {
            $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Pet Successfully Added!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
          } else {
            $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error adding pet!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
          }
        } else {
          $alertMessage = "Error uploading the file.";
        }
      } else {
        $alertMessage = "Invalid file type. Allowed types: JPG, JPEG, PNG, GIF, PDF, DOC, DOCX.";
      }
    } else {
      $alertMessage = "No file uploaded or an error occurred during upload.";
    }
  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }
}

// displaying pets***************************************************************************************
try {
  $stmt = $pdo->prepare('SELECT * FROM tbl_pet');
  $stmt->execute();
  $pet = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}

// displaying pet category options*******************************************************************
try {
  $stmt = $pdo->prepare('SELECT * FROM tbl_pet_category');
  $stmt->execute();
  $pet_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('Error: ' . $e->getMessage());
}

// deleting pet ***********************************************
ob_start();

if (isset($_GET['delete_pet_id'])) {
  $delete_pet_id = $_GET['delete_pet_id'];

  // perform the database delete query
  $stmt = $pdo->prepare('DELETE FROM tbl_pet WHERE pet_id = :delete_pet_id');
  $stmt->bindParam(':delete_pet_id', $delete_pet_id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    // redirect back to the page after successful deletion
    echo "Pet has been deleted.";
  } else {
    echo "Error deleting pet.";
  }
}

ob_end_flush();

// editing pet ****************************************************
if (isset($_POST['edit_submit'])) {
  $pet_id = $_POST['edit_pet_id'];
  $pet_name = $_POST['edit_pet_name'];
  $pet_description = $_POST['edit_pet_description'];
  $pet_category_id = $_POST['edit_pet_category_id'];
  $pet_price = $_POST['edit_pet_price'];


  // perform the database update query
  $stmt = $pdo->prepare('UPDATE tbl_pet SET pet_name = :pet_name, pet_description = :pet_description, pet_category_id = :pet_category_id, pet_price = :pet_price WHERE pet_id = :pet_id');
  $stmt->bindParam(':pet_name', $pet_name, PDO::PARAM_STR);
  $stmt->bindParam(':pet_description', $pet_description, PDO::PARAM_STR);
  $stmt->bindParam(':pet_category_id', $pet_category_id, PDO::PARAM_INT);
  $stmt->bindParam(':pet_price', $pet_price, PDO::PARAM_STR);
  $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    // successful update
    echo "Successfully updated Pet.";
  } else {
    // error handling for the update query
    echo "Error updating pet.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Store Admin - Manage Pets</title>

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
  <link rel="stylesheet" type="text/css" href="file.css">
</head>

<body class="hold-transition sidebar-mini">
  <!-- Navbar start  -->
  <!-- wrapper -->
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light navbar-green">

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
    <!--navbar end-->

    <!-- Main Sidebar Container Start -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/index.php" class="brand-link">
        <img src="../dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Pet Store </span>
      </a>

      <!-- Sidebar Start -->
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
                  <a href="petcategory.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Pet Category</p>
                  </a>
                </li>
                <!-- pet management -->
                <li class="nav-item">
                  <a href="petmanagement.php" class="nav-link active">
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
              <h1>Pet Management</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Pet</a></li>
                <li class="breadcrumb-item active">Management</li>
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
                  <h3 class="card-title">Pet Management Data table</h3>
                  <!-- Add start -->
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add" style="margin-left:74%"><i class="fa fa-plus">Add</i>
                  </button>

                  <!-- add form start  -->
                  <div class="modal fade" id="add" name="add">
                    <div class="modal-dialog modal-md">

                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Management</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="col-12">
                                <div class="form-group">
                                  <label for="pet_name">Pet Name</label>
                                  <input type="text" class="form-control" id="pet_name" name="pet_name" placeholder="Enter Pet's name..">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="pet_description" rows="3" placeholder="Enter ..."></textarea>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label for="user_id">User ID</label>
                                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter User ID..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" row="5" name="pet_category_id">
                                      <?php foreach ($pet_categories as $category) : ?>
                                        <option value="<?php echo $category['pet_category_id']; ?>"><?php echo $category['pet_category_name']; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label for="user_id">Pet Price</label>
                                    <input type="text" class="form-control" name="pet_price" placeholder="Enter price for pet..">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label for="pet_images" class="btn-2"><i class="fa fa-file-image"></i> Upload Image</label>
                                    <input type="file" id="pet_images" name="pet_images" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-check"></i> Submit</button>
                          </div>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
                <!-- add end -->

                <!-- /.card-header -->
                <div class="card-body">
                  <!-- table to pet data -->
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Pet ID</th>
                        <th>Pet Name</th>
                        <th>Pet Description</th>
                        <th>Pet Category ID</th>
                        <th>Pet Price</th>
                        <th width="12%">Pet Image</th>
                        <th width="7%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($pet as $list) : ?>
                        <tr>
                          <td><?= $list['pet_id']; ?></td>
                          <td><?= $list['pet_name']; ?></td>
                          <td><?= $list['pet_description']; ?></td>
                          <td><?= $list['pet_category_id']; ?></td>
                          <td><?= $list['pet_price']; ?></td>
                          <td>
                            <img src="<?= $list['pet_images']; ?>" alt="Pet Image" width="100px">
                          </td>

                          <td>
                            <!-- edit button -->
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#update"><i class="fa fa-pencil-alt"></i>
                            </button>

                            <!-- delete button -->
                            <button type="button" class="btn btn-danger btn-xs" onclick="deletePet(<?= $list['pet_id']; ?>)"><i class="fa fa-trash"></i>
                            </button>

                            <!-- JavaScript function -->
                            <script>
                              function deletePet(petId) {
                                if (confirm("Are you sure you want to delete this pet?")) {
                                  window.location.href = "?delete_pet_id=" + petId;
                                }
                              }
                            </script>

                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <!-- update -->
                  <div class="modal fade" id="update">
                    <div class="modal-dialog modal-md">

                      <form action="" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Update Pet</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="row">

                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Pet ID</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_pet_id" placeholder="Enter..">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Pet Name</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_pet_name" placeholder="Enter Name..">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Pet Description</label>
                                    <textarea class="form-control" name="edit_pet_description" rows="3" placeholder="Enter ..."></textarea>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Pet Category</label>
                                    <select class="form-control" name="edit_pet_category_id">
                                      <option value="1">Dog</option>
                                      <option value="2">Cat</option>
                                      <option value="3">Bird</option>
                                      <option value="4">Fish</option>
                                      <option value="5">Small Mammals</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Pet Price</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_pet_price" placeholder="Enter price..">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> close</button>
                            <button type="submit" class="btn btn-primary" name="edit_submit"><i class="fa fa-check"></i> submit</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                </div>
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
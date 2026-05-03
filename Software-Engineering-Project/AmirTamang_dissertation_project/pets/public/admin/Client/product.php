<?php
session_start();
// <!-- this code section is for connecting the database -->
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

//for adding products **************************************************
$alertMessage = '';

if (isset($_POST['submit'])) {
  try {
    $user_id_value = 1;

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {

      $upload_dir = '../../pimg/';

      $upload_file = $upload_dir . basename($_FILES['product_image']['name']);

      $file_extension = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

      $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx');

      if (in_array($file_extension, $allowed_extensions)) {

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_file)) {

          $stmt = $pdo->prepare('INSERT INTO tbl_pet_product (product_code, product_name, product_detail, product_image, product_category_id, quantity_on_hand, retail_price, discount, user_id) VALUES (:product_code, :product_name, :product_detail, :product_image, :product_category_id, :quantity_on_hand, :retail_price, :discount, :user_id)');

          $stmt->bindParam(':product_code', $_POST['product_code']);
          $stmt->bindParam(':product_name', $_POST['product_name']);
          $stmt->bindParam(':product_detail', $_POST['product_detail']);
          $stmt->bindParam(':product_image', $upload_file);
          $stmt->bindParam(':product_category_id', $_POST['product_category_id']);
          $stmt->bindParam(':quantity_on_hand', $_POST['quantity_on_hand']);
          $stmt->bindParam(':retail_price', $_POST['retail_price']);
          $stmt->bindParam(':discount', $_POST['discount']);
          $stmt->bindParam(':user_id', $user_id_value);

          if ($stmt->execute()) {
            $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Product Successfully Added!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
          } else {
            $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error adding product!
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

// displaying products***************************************************************************************
try {
  $stmt = $pdo->prepare('SELECT * FROM tbl_pet_product');
  $stmt->execute();
  $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}

// displaying pet category options*****************************************************************************
try {
  $stmt = $pdo->prepare('SELECT * FROM tbl_pet_product_category');
  $stmt->execute();
  $product_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('Error: ' . $e->getMessage());
}

// deleting product ***********************************************
ob_start();

if (isset($_GET['delete_product_id'])) {
  $delete_product_id = $_GET['delete_product_id'];

  // perform the database delete query
  $stmt = $pdo->prepare('DELETE FROM tbl_pet_product WHERE product_id = :delete_product_id');
  $stmt->bindParam(':delete_product_id', $delete_product_id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    // redirect back to the page after successful deletion
    echo "Product has been deleted.";
  } else {
    echo "Error deleting product.";
  }
}

ob_end_flush();

// editing product ****************************************************
if (isset($_POST['edit_submit'])) {
  $pet_product_id = $_POST['edit_pet_product_id'];
  $product_code = $_POST['edit_product_code'];
  $product_name = $_POST['edit_product_name'];
  $product_detail = $_POST['edit_product_detail'];
  $product_category_id = $_POST['edit_product_category_id'];
  $quantity_on_hand = $_POST['edit_quantity_on_hand'];
  $retail_price = $_POST['edit_retail_price'];
  $discount = $_POST['edit_discount'];

  // perform the database update query
  $stmt = $pdo->prepare('UPDATE tbl_pet_product SET product_code = :product_code, product_name = :product_name, product_detail = :product_detail, product_category_id = :product_category_id, quantity_on_hand = :quantity_on_hand, retail_price = :retail_price, discount = :discount WHERE pet_product_id = :pet_product_id');
  $stmt->bindParam(':pet_product_id', $pet_product_id, PDO::PARAM_INT);
  $stmt->bindParam(':product_code', $product_code, PDO::PARAM_STR);
  $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
  $stmt->bindParam(':product_detail', $product_detail, PDO::PARAM_STR);
  $stmt->bindParam(':product_category_id', $product_category_id, PDO::PARAM_INT);
  $stmt->bindParam(':quantity_on_hand', $quantity_on_hand, PDO::PARAM_INT);
  $stmt->bindParam(':retail_price', $retail_price, PDO::PARAM_STR);
  $stmt->bindParam(':discount', $discount, PDO::PARAM_STR);

  if ($stmt->execute()) {
    // successful update
    echo "Successfully updated Product.";
  } else {
    // error handling for the update query
    echo "Error updating product.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Store - Manange Product </title>
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
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-green">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>



      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->

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
                  <a href="petmanagement.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Pet Management</p>
                  </a>
                </li>
                <!-- pet category -->
                <li class="nav-item">
                  <a href="productcategory.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pet Product Category</p>
                  </a>
                </li>
                <!-- pet product -->
                <li class="nav-item">
                  <a href="product.php" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pet Product</p>
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
              <h1>Pet Product</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Pet</a></li>
                <li class="breadcrumb-item active">Product</li>
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
                  <h3 class="card-title">Pet Product Data table</h3>
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add" style="margin-left:77%"><i class="fa fa-plus">Add</i>
                  </button>
                  <div class="modal fade" id="add" name="add">
                    <div class="modal-dialog modal-md">

                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <label> Product Code</label>
                                    <input type="text" class="form-control" row="5" name="product_code" placeholder="Enter Product Code..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label> Product Name</label>
                                    <input type="text" class="form-control" row="5" name="product_name" placeholder="Enter Product Name..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Product Detail</label>
                                    <input type="text" class="form-control" row="5" name="product_detail" placeholder="Enter Product Detail..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Product Category</label>
                                    <select class="form-control" row="5" name="product_category_id">
                                      <?php foreach ($product_categories as $category) : ?>
                                        <option value="<?php echo $category['product_category_id']; ?>"><?php echo $category['product_category_name']; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" row="5" name="quantity_on_hand" placeholder="0">
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Retail Price</label>
                                    <input type="text" class="form-control" row="5" name="retail_price" placeholder="Rs. 0000.00">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" class="form-control" row="5" name="discount" placeholder="0">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>User ID</label>
                                    <input type="text" class="form-control" row="5" name="user_id" placeholder="Enter User ID...">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label class="btn-2"><i class="fa fa-file-image"></i> Upload Image</label>
                                    <input type="file" id="product_image" name="product_image" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> close</button>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-check"></i> submit</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                </div>

                <!-- display -->
                <!-- /.card-header -->
                <div class="card-body">

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Product ID</th>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Detail</th>
                        <th>Image</th>
                        <th>Category ID</th>
                        <th>Quantity</th>
                        <th>Retail Price</th>
                        <th>Discount(%)</th>
                        <th>User ID</th>
                        <th width="7%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($product as $list) : ?>
                        <tr>
                          <th><?= $list['product_id']; ?></th>
                          <td><?= $list['product_code']; ?></td>
                          <td><?= $list['product_name']; ?></td>
                          <td><?= $list['product_detail']; ?></td>
                          <td><!-- Display the image using the img tag -->
                            <img src="<?= $list['product_image']; ?>" alt="Product Image" width="100px">
                          </td>
                          <td><?= $list['product_category_id']; ?></td>
                          <td><?= $list['quantity_on_hand']; ?></td>
                          <td><i style="color:blue"><?= $list['retail_price']; ?></i></td>
                          <td><i style="color:red"><?= $list['discount']; ?></i></td>
                          <th><?= $list['user_id']; ?></th>
                          <td>
                            <!-- edit -->
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#update"><i class="fa fa-pencil-alt"></i>
                            </button>
                            <!-- delete -->
                            <button type="button" class="btn btn-danger btn-xs" onclick="deleteProduct(<?= $list['product_id']; ?>)"><i class="fa fa-trash"></i>
                            </button>
                            <!-- JavaScript function -->
                            <script>
                              function deleteProduct(petProductId) {
                                if (confirm("Are you sure you want to delete this product?")) {
                                  window.location.href = "?delete_product_id=" + petProductId;
                                }
                              }
                            </script>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <!-- update-->
                  <div class="modal fade" id="update">
                    <div class="modal-dialog modal-md">
                      <form action="" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Update Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Product ID</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_pet_product_id" placeholder="Enter Product ID..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Product Code</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_product_code" placeholder="Enter Product Code..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_product_name" placeholder="Enter Product Name..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Detail</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_product_detail" placeholder="Enter Product Detail..">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Product Category</label>
                                    <select class="form-control" row="5" name="edit_product_category_id">
                                      <option value="1">Toys</option>
                                      <option value="2">Foods and Treats</option>
                                      <option value="3">Collar and Leashes</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" row="5" id="" name="edit_quantity_on_hand" placeholder="0">
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Retail Price</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_retail_price" placeholder="Rs. 0000.00">
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" class="form-control" row="5" id="" name="edit_discount" placeholder="0">
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
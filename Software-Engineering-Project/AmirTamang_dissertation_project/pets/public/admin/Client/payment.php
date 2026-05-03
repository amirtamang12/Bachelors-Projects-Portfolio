<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// retrieve and display the peyments in the table *****************
try {
  $stmt = $pdo->prepare('SELECT * FROM tbl_payment');
  $stmt->execute();
  $payment = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Store - Payment </title>
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
        <span href="dashboard.php" class="brand-text font-weight-light">Pet Store</span>
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
            <li class="nav-item">
              <a class="nav-link">
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
                  <a href="product.php" class="nav-link">
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
              <a href="payment.php" class="nav-link" style="background-color: #e83e8c; color: white;">
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
              <h1>Payment</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Payment</li>
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
                  <h3 class="card-title">Payment Data table</h3>
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add" style="margin-left:77%"><i class="fa fa-plus">Add</i>
                  </button>
                  <div class="modal fade" id="add">
                    <div class="modal-dialog modal-md">
                      <form action=".php" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Payment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-9">
                                  <div class="form-group">
                                    <label>Reference No.</label>
                                    <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Reference No ..">
                                  </div>
                                </div>

                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Amount Paid</label>
                                    <input type="number" class="form-control" row="5" id="" name="" placeholder="0">
                                  </div>
                                </div>

                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Payment Status">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" row="3" id="" name="" placeholder="Enter.."></textarea>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Customer</label>
                                    <select class="form-control">
                                      <option>option 1</option>
                                      <option>option 2</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Paid By</label>
                                    <input type="number" class="form-control" row="5" id="" name="" placeholder="Enter Paid By ..">
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                          </div>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Payment ID</th>
                        <th>Payment For</th>
                        <th>Amount Paid</th>
                        <th>Remarks</th>
                        <th>Payment Status</th>
                        <th>Paid By</th>
                        <th>User ID</th>
                        <th width="7%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($payment as $pay) : ?>
                        <tr>
                          <td><?= $pay['payment_id']; ?></td>
                          <td><?= $pay['payment_for']; ?></td>
                          <td><?= $pay['amount_paid']; ?></td>
                          <td><?= $pay['remarks']; ?></td>
                          <td><?= $pay['payment_status']; ?></td>
                          <td><?= $pay['paid_by']; ?></td>
                          <td><?= $pay['user_id']; ?></td>
                          <td>
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#update"><i class="fa fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <div class="modal fade" id="update">
                    <div class="modal-dialog modal-md">
                      <form action=".php" method="post">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Update Payment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="card card-primary">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-9">
                                  <div class="form-group">
                                    <label>Reference No.</label>
                                    <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Reference No ..">
                                  </div>
                                </div>

                                <div class="col-3">
                                  <div class="form-group">
                                    <label>Amount Paid</label>
                                    <input type="number" class="form-control" row="5" id="" name="" placeholder="0">
                                  </div>
                                </div>

                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Payment Status">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" row="3" id="" name="" placeholder="Enter.."></textarea>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Customer</label>
                                    <select class="form-control">
                                      <option>option 1</option>
                                      <option>option 2</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label>Paid By</label>
                                    <input type="number" class="form-control" row="5" id="" name="" placeholder="Enter Paid By ..">
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
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
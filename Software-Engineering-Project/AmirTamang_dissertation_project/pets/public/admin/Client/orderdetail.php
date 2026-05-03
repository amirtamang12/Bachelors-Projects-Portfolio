<?php
session_start();
// <!-- this code section is for connecting the database -->
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// retrieve and display the order details in the table ************************************************
try {
    $stmt = $pdo->prepare('SELECT * FROM tbl_order_detail');
    $stmt->execute();
    $ods = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Store- Order Details</title>

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
                        <li class="nav-item">
                            <a class="nav-link">
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
                        <li class="nav-item menu-open">
                            <a href="orderdetail.php" class="nav-link active" style="background-color: #e83e8c; color: white;">
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
                            <h1>Order Detail</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Order Detail</li>
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
                                    <h3 class="card-title">Order Detail Data table</h3>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order Detail ID</th>
                                                <th>Order ID</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ods as $od) : ?>
                                                <tr>
                                                    <td><?= $od['order_detail_id']; ?></td>
                                                    <td><?= $od['order_id']; ?></td>
                                                    <td><?= $od['quantity']; ?></td>
                                                    <td><i style="color: blue"><?= $od['quantity_price']; ?></i></td>
                                                    <td><?= $od['status']; ?></td>
                                                    <td><?= $od['remarks']; ?></td>
                                                </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="modal fade" id="update">
                                        <div class="modal-dialog modal-md">
                                            <form action=".php" method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Update Services</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="card card-primary">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label>Reference No.</label>
                                                                        <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Reference No ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label>Service</label>
                                                                        <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Service Name ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label>Service Detail</label>
                                                                        <input type="text" class="form-control" row="5" id="" name="" placeholder="Enter Service Detail ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label>Vendor</label>
                                                                        <select class="form-control">
                                                                            <option>option 1</option>
                                                                            <option>option 2</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label>Service Fee</label>
                                                                        <input type="number" class="form-control" row="5" id="" name="" placeholder="0">
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
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Footer <a href="">Pet Shop Magement System</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Footer</b>
            </div>
        </footer>

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
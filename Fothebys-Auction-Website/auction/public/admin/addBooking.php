<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $aleartMessage variable
$aleartMessage = '';

if (isset($_POST['save_booking_btn'])) {
  // Insert query
  $stmt = $pdo->prepare('INSERT INTO bookings (customerName, customerEmail, bookingDate, packageName, vehicleName, hotelName, startDate, totalCost)
                         VALUES (:customerName, :customerEmail, :bookingDate, :packageName, :vehicleName, :hotelName, :startDate, :totalCost)');

  $criteria = [
    ':customerName' => $_POST['customerName'],
    ':customerEmail' => $_POST['customerEmail'],
    ':bookingDate' => $_POST['bookingDate'],
    ':packageName' => $_POST['packageName'],
    ':vehicleName' => $_POST['vehicleName'],
    ':hotelName' => $_POST['hotelName'],
    ':startDate' => $_POST['startDate'],
    ':totalCost' => $_POST['totalCost'],
  ];

  $queryResult = $stmt->execute($criteria);

  if ($queryResult) {
    $_SESSION['message'] = 'Booking Successfully Added!';
    // Redirect to packages.php using JavaScript
    echo '<script>window.location.href = "booking.php";</script>';
} else {
    $_SESSION['message'] = 'Error Adding Booking!';
}

}

?>
<!-- The rest of your HTML content goes here -->

<main id="main" class="main">

  <?php echo $aleartMessage; ?>
  <!-- JavaScript to automatically close the alert after a delay -->
  <script>
    // Function to close the alert after a delay
    function closeAlert() {
      var alert = document.querySelector('.alert');
      if (alert) {
        alert.style.display = 'none';
      }
    }

    // Automatically close the alert after 3 seconds
    setTimeout(closeAlert, 3000);
  </script>
  <div class="pagetitle">
    <h1>Add Booking</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="booking.php">Booking</a></li>
        <li class="breadcrumb-item active"><a href="addBooking.php">Add Booking</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
      <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Booking</h5>
              <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p>
             
              <!-- Table with stripped rows -->
              <form action="addBooking.php" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Package Name</label>
                  <div class="col-sm-10">
                    <input type="text"  name="packageName" class="form-control"/>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Customer Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="customerName" class="form-control"/>
                  </div>
                </div>

                <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Customer Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="customerEmail" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Hotel Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="hotelName" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Vehicle Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="vehicleName" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">Booking Date</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" name="bookingDate">
                  </div>
                </div>
                <div class="row mb-3">
                <label for="inputDate" class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-10">
                                <input type="date" name="startDate" class="form-control"/>
                    </div>
                </div>
<div class="input-group mb-3">
                      <span class="input-group-text">$</span>
                      <input type="text" class="form-control" name="totalCost" aria-label="Amount (to the nearest dollar)"/>
                      <span class="input-group-text">.00</span>
                    </div>
<div class="row mb-3">
  <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
  <div class="col-sm-10">
    <button type="submit" class="btn btn-primary" name="save_booking_btn">Post</button>
  </div>
</div>

</form>
<script>
    tinymce.init({
        selector: "textarea#packageDescription",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste",
        ],
        toolbar: "bold italic | fontsizeselect fontselect",
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
        font_formats: "Arial=arial,helvetica,sans-serif;Comic Sans MS=comic sans ms,sans-serif;Times New Roman=times new roman,times,serif",
    });
</script>

            </div>
      </div>
    </div>
  </section>
</main>
<?php
include('layouts/footer.php')
?>

<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

try {
    $stmt = $pdo->prepare('SELECT d.*, i.LotNumber FROM Drawings d
                           LEFT JOIN Items i ON d.ItemID = i.ItemID');
    $stmt->execute();
    $drawings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Drawing Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Drawing</li>
                <li class="breadcrumb-item active">Drawing Table</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION['message'])) {
                    echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
                    unset($_SESSION['message']); // Clear the session message
                } ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Drawing Table</h5>
                        <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to convert to a datatable</p>
                        <a href="addDrawings.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Lot Number</th>
                                    <th scope="col">Medium</th>
                                    <th scope="col">Framed</th>
                                    <th scope="col">Height (in cm)</th>
                                    <th scope="col">Length (in cm)</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($drawings as $drawing) {
                                    echo '<tr>';
                                    echo '<td>' . $drawing['LotNumber'] . '</td>';
                                    echo '<td>' . $drawing['DrawingMedium'] . '</td>';
                                    echo '<td>' . ($drawing['IsFramed'] ? 'Yes' : 'No') . '</td>';
                                    echo '<td>' . $drawing['HeightInCm'] . '</td>';
                                    echo '<td>' . $drawing['LengthInCm'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editDrawings.php?id=' . $drawing['DrawingID'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deleteDrawings.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $drawing['DrawingID'] . '" />
                                        <button type="submit" name="delete_drawing" class="btn btn-danger">Delete</button>
                                    </form>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include('layouts/footer.php')
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>
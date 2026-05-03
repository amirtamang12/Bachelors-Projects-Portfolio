<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

try {
    $stmt = $pdo->prepare('SELECT s.*, i.LotNumber FROM Sculptures s
                           LEFT JOIN Items i ON s.ItemID = i.ItemID');
    $stmt->execute();
    $sculptures = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Sculptures Table</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Sculptures</li>
                <li class="breadcrumb-item active">Sculptures Table</li>
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
                        <h5 class="card-title">Sculptures Table</h5>
                        <p>Add, edit, delete sculptures</p>
                        <a href="addSculptures.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Lot Number</th>
                                    <th scope="col">Material Used</th>
                                    <th scope="col">Height (cm)</th>
                                    <th scope="col">Length (cm)</th>
                                    <th scope="col">Width (cm)</th>
                                    <th scope="col">Approx. Weight (kg)</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($sculptures as $sculpture) {
                                    echo '<tr>';
                                    echo '<td>' . $sculpture['LotNumber'] . '</td>';
                                    echo '<td>' . $sculpture['MaterialUsed'] . '</td>';
                                    echo '<td>' . $sculpture['HeightInCm'] . '</td>';
                                    echo '<td>' . $sculpture['LengthInCm'] . '</td>';
                                    echo '<td>' . $sculpture['WidthInCm'] . '</td>';
                                    echo '<td>' . $sculpture['ApproxWeightInKg'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editSculptures.php?id=' . $sculpture['SculptureID'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deleteSculptures.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $sculpture['SculptureID'] . '" />
                                        <button type="submit" name="delete_sculpture" class="btn btn-danger">Delete</button>
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
include('layouts/footer.php');
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>
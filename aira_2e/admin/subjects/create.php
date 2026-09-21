<?php 
session_start();
include "../../config/database.php";

// Only admin users can access this page
if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
    header("Location:../../index.php");
    exit;
}

$message = "";

if(isset($_POST["save"])){
    $subject_code = trim($_POST['subject_code']);
    $subject_name = trim($_POST['subject_name']);
    $units = (int)$_POST['units'];

    // Prepared Statement to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name, units) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $subject_code, $subject_name, $units);

    if($stmt->execute()){
        $message = "Subject Created Successfully";
        header("Location: index.php?message=" . urlencode($message));
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Subject Form</title>

    <!-- Bootstrap CSS -->
    <link
        href="../../assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <!-- Main Container -->
    <div
        class="container py-5"
        style="max-width: 700px;"
    >

        <!-- Subject Form Card -->
        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h2>Subject Form</h2>
    <?php if($message != ""){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php } ?>


                <form>

                    <!-- Subject Code -->
                    <div class="mb-3">
                        <label class="form-label">
                            Subject Code
                        </label>

                        <input class="form-control">
                    </div>

                    <!-- Subject Name -->
                    <div class="mb-3">
                        <label class="form-label">
                            Subject Name
                        </label>

                        <input class="form-control">
                    </div>

                    <!-- Units -->
                    <div class="mb-3">
                        <label class="form-label">
                            Units
                        </label>

                        <input
                            type="number"
                            class="form-control"
                        >
                    </div>

                    <!-- Form Actions -->
                    <button
                        type="button"
                        class="btn btn-primary"
                    >
                        Save Subject
                    </button>

                    <a
                        href="subjects.html"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>

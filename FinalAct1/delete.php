<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Applicant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    session_start();
    require_once 'core/dbConfig.php';
    require_once 'core/models.php';

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']); // Sanitize the ID for security

        // Fetch applicant details from the database
        $query = $pdo->prepare("SELECT * FROM engineer_job_applications WHERE id = :id");
        $query->execute(['id' => $id]);
        $applicant = $query->fetch(PDO::FETCH_ASSOC);

        if ($applicant) {
            // If the user has confirmed the deletion
            if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
                $deleteResponse = deleteApplicant($pdo, $id);  // Make sure you have deleteApplicant function in your model
                $_SESSION['message'] = $deleteResponse['message'];
                header('Location: index.php');
                exit();
            }

            // Display confirmation prompt with applicant details
            ?>
            <div class="conformation-container">
                <h1>Are you sure you want to delete the following applicant?</h1>
                <div class="applicant-details">
                    <p><strong>First Name:</strong> <?php echo htmlspecialchars($applicant['first_name']); ?></p>
                    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($applicant['last_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($applicant['email']); ?></p>
                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($applicant['specialization']); ?></p>
                    <p><strong>Years of Experience:</strong> <?php echo htmlspecialchars($applicant['years_of_experience']); ?></p>
                    <p><strong>Current Employer:</strong> <?php echo htmlspecialchars($applicant['current_employer']); ?></p>
                    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($applicant['phone_number']); ?></p>
                    <p><strong>Application Status:</strong> <?php echo htmlspecialchars($applicant['application_status']); ?></p>
                    <p><strong>Date Applied:</strong> <?php echo htmlspecialchars($applicant['date_applied']); ?></p>
                </div>
                <div class="action-buttons">
                    <a href="index.php" class="btn clear-search">Back</a>
                    <a href="delete.php?id=<?php echo $id; ?>&confirm=yes" class="btn clear-search">Confirm</a>
                </div>
            </div>
            <?php
        } else {
            echo '<p>Error: Applicant not found.</p>';
        }
    } else {
        echo '<p>Error: No applicant ID provided.</p>';
    }
    ?>
</body>
</html>

<?php
session_start();  // Make sure session is started at the top of the file
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['searchBtn'])) {
    $searchResult = searchApplicants($pdo, $_GET['searchInput']);
    $applicants = $searchResult['querySet'] ?? [];
    $message = $searchResult['message'];
    $searchSuccessMessage = !empty($applicants) ? "Search completed successfully! Found " . count($applicants) . " result(s)." : "No applicants found matching your search.";
} else {
    $allApplicants = getAllApplicants($pdo);
    $applicants = $allApplicants['querySet'] ?? [];
    $message = $allApplicants['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Engineer Job Applications</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
        BuildBright Engineering Recruitment Agency
        </header>
        
        <!-- Display Success Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <p class="message success"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); // Clear the message after displaying it ?>
        <?php endif; ?>

        <h1>Applicant Tracking Center</h1>

        <form action="index.php" method="GET">
            <input type="text" name="searchInput" placeholder="Search for applicants">
            <input type="submit" name="searchBtn" value="Search">
        </form>

        <div class="action-buttons">
            <a class="btn clear-search" href="index.php">Clear Search</a>
            <a class="btn insert-applicant" href="insert.php">Insert New Applicant</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Specialization</th>
                    <th>Years of Experience</th>
                    <th>Recent Company</th>
                    <th>Phone Number</th>
                    <th>Application Status</th>
                    <th>Date Applied</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applicants)) {
                    foreach ($applicants as $applicant) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($applicant['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['email']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['specialization']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['years_of_experience']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['current_employer']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['application_status']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['date_applied']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $applicant['id']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $applicant['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo '<tr><td colspan="9">No applicants found.</td></tr>';
                } ?>
            </tbody>
        </table>

        <footer>
            BuildBright Engineering Recruitment Agency since 2024
        </footer>
    </div>
</body>
</html>

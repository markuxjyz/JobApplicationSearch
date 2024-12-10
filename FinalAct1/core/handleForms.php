<?php
session_start();
require_once 'dbConfig.php';
require_once 'models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insertUserBtn'])) {
        $result = insertApplicant($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], 
            $_POST['specialization'], $_POST['years_of_experience'], $_POST['current_employer'], $_POST['expected_salary'], 
            $_POST['phone_number'], $_POST['application_status']);
        $_SESSION['message'] = $result ? "Applicant successfully added." : "Failed to add applicant.";
    } elseif (isset($_POST['editUserBtn'])) {
        $id = $_GET['id'] ?? null;
        $result = updateApplicant($pdo, $id, $_POST['first_name'], $_POST['last_name'], $_POST['email'], 
            $_POST['specialization'], $_POST['years_of_experience'], $_POST['current_employer'], $_POST['expected_salary'], 
            $_POST['phone_number'], $_POST['application_status']);
        $_SESSION['message'] = $result ? "Applicant successfully updated." : "Failed to update applicant.";
    }

    header("Location: ../index.php");
    exit();
}

?>
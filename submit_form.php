<?php
include 'config.php';

// Get main person details
$main_person_name = $_POST['main_person_name'];
$home_address = $_POST['home_address'];

// Insert into families table
$sql = "INSERT INTO families (main_person_name, home_address) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $main_person_name, $home_address);

if ($stmt->execute()) {
    $family_id = $stmt->insert_id;

    // Insert each family member into the family_members table
    $member_names = $_POST['member_name'];
    $member_ages = $_POST['member_age'];
    $member_marital_statuses = $_POST['member_marital_status'];
    $member_occupations = $_POST['member_occupation'];

    $stmt_member = $conn->prepare("INSERT INTO family_members (family_id, name, age, marital_status, occupation) VALUES (?, ?, ?, ?, ?)");

    for ($i = 0; $i < count($member_names); $i++) {
        $stmt_member->bind_param("isiss", $family_id, $member_names[$i], $member_ages[$i], $member_marital_statuses[$i], $member_occupations[$i]);
        $stmt_member->execute();
    }

    $stmt_member->close();
    $stmt->close();
    $conn->close();

    // Redirect to index.php with success message
    header("Location: index.php?success=1");
    exit();
} else {
    // Redirect to index.php with failure message
    header("Location: index.php?success=0");
    exit();
}
?>
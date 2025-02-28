<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "mani#200312";
$dbname = "admin_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
$branch = $_POST['branch'];
$role = $_POST['role'];

// Check if the role is 'hod' and if a hod already exists for the branch
if ($role == "hod") {
    $check_sql = "SELECT id FROM users WHERE branch = '$branch' AND role = 'hod'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // A HOD already exists for this branch
        die("Error: Only one HOD can be added per branch.");
    }
}

// Insert user into database
$sql = "INSERT INTO users (username, email, password, branch, role) VALUES ('$username', '$email', '$password', '$branch', '$role')";

if ($conn->query($sql) === TRUE) {
    // Create folder based on role
    $uploads_dir = "uploads/";
    
    if ($role == "hod") {
        // Create HOD folder inside the uploads (principal) folder
        $hod_dir = $uploads_dir . $username . "/";
        if (!file_exists($hod_dir)) {
            mkdir($hod_dir, 0777, true);
            echo "HOD folder created successfully.<br>";

            // Create "principal_share" folder inside the HOD folder
            $principal_share_dir = $hod_dir . "principal_share/";
            if (!file_exists($principal_share_dir)) {
                mkdir($principal_share_dir, 0777, true);
                echo "Principal Share folder created inside HOD folder.<br>";
            }
        }
    } elseif ($role == "faculty") {
        // Fetch the HOD username for the faculty's branch
        $hod_sql = "SELECT username FROM users WHERE branch = '$branch' AND role = 'hod'";
        $hod_result = $conn->query($hod_sql);

        if ($hod_result->num_rows > 0) {
            $hod_row = $hod_result->fetch_assoc();
            $hod_username = $hod_row['username'];

            // Create HOD folder if it doesn't exist
            $hod_dir = $uploads_dir . $hod_username . "/";
            if (!file_exists($hod_dir)) {
                mkdir($hod_dir, 0777, true);
                echo "HOD folder created successfully.<br>";
            }

            // Create faculty folder inside the HOD folder
            $faculty_dir = $hod_dir . $username . "/";
            if (!file_exists($faculty_dir)) {
                mkdir($faculty_dir, 0777, true);
                echo "Faculty folder created successfully.<br>";

                // Create "hod_share" folder inside the faculty folder
                $hod_share_dir = $faculty_dir . "hod_share/";
                if (!file_exists($hod_share_dir)) {
                    mkdir($hod_share_dir, 0777, true);
                    echo "HOD Share folder created inside faculty folder.<br>";
                }

                // Create "faculty_files" folder inside the faculty folder
                $faculty_files_dir = $faculty_dir . "faculty_files/";
                if (!file_exists($faculty_files_dir)) {
                    mkdir($faculty_files_dir, 0777, true);
                    echo "Faculty Files folder created inside faculty folder.<br>";
                }
            }
        } else {
            echo "Error: No HOD found for the branch '$branch'. Faculty folder not created.";
        }
    }

    echo "New user created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<?php
session_start();

// Check if the user is logged in and is the principal
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'principal') {
    header("Location: login.php");
    exit();
}

$uploads_folder = "uploads/";

// Fetch all HOD folders
$hod_folders = [];
if (is_dir($uploads_folder)) {
    $folders = scandir($uploads_folder);
    foreach ($folders as $folder) {
        if ($folder !== '.' && $folder !== '..' && is_dir($uploads_folder . $folder)) {
            $hod_folders[] = $folder;
        }
    }
}

// Check if an HOD folder is selected
$selected_hod_folder = isset($_GET['hod_folder']) ? $_GET['hod_folder'] : null;

// Fetch the "principal_share" folder inside the selected HOD folder
$principal_share_folder = null;
$principal_share_files = [];
if ($selected_hod_folder && is_dir($uploads_folder . $selected_hod_folder)) {
    $principal_share_folder = $uploads_folder . $selected_hod_folder . "/principal_share/";
    if (is_dir($principal_share_folder)) {
        $principal_share_files = scandir($principal_share_folder);
        $principal_share_files = array_diff($principal_share_files, ['.', '..']);
    }
}

// Handle file upload to the "principal_share" folder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['file']['name']);
        $file_path = $principal_share_folder . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            $message = "File uploaded successfully.";
        } else {
            $message = "Failed to upload file.";
        }
    } else {
        $message = "No file selected or upload error.";
    }
}

// Handle file deletion from the "principal_share" folder
if (isset($_GET['delete'])) {
    $file_to_delete = $principal_share_folder . basename($_GET['delete']);
    if (file_exists($file_to_delete)) {
        if (unlink($file_to_delete)) {
            $message = "File deleted successfully.";
        } else {
            $message = "Failed to delete file.";
        }
    } else {
        $message = "File not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .dashboard-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .folder-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .folder-item {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        .folder-item:hover {
            background-color: #0056b3;
        }
        .file-list {
            margin-top: 20px;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .file-item a {
            color: #007bff;
            text-decoration: none;
        }
        .file-item a:hover {
            text-decoration: underline;
        }
        .file-item button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .file-item button:hover {
            background-color: #c82333;
        }
        .upload-form {
            margin-top: 20px;
        }
        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }
        .upload-form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .upload-form button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Principal Dashboard</h1>
        <h2>HOD Folders</h2>
        <div class="folder-list">
            <?php if (!empty($hod_folders)): ?>
                <?php foreach ($hod_folders as $folder): ?>
                    <a href="principal_dashboard.php?hod_folder=<?php echo $folder; ?>" class="folder-item">
                        <?php echo $folder; ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No HOD folders found.</p>
            <?php endif; ?>
        </div>

        <?php if ($selected_hod_folder): ?>
            <h2>Principal Share Folder in <?php echo $selected_hod_folder; ?></h2>

            <!-- File Upload Form -->
            <div class="upload-form">
                <h3>Upload File to Principal Share Folder</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" required>
                    <button type="submit" name="upload">Upload</button>
                </form>
            </div>

            <!-- Display Files in Principal Share Folder -->
            <div class="file-list">
                <h3>Files in Principal Share Folder</h3>
                <?php if (!empty($principal_share_files)): ?>
                    <?php foreach ($principal_share_files as $file): ?>
                        <div class="file-item">
                            <a href="<?php echo $principal_share_folder . $file; ?>" target="_blank"><?php echo $file; ?></a>
                            <button onclick="deleteFile('<?php echo $file; ?>')">Delete</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No files found in the principal share folder.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

    <script>
        function deleteFile(fileName) {
            if (confirm("Are you sure you want to delete this file?")) {
                window.location.href = "principal_dashboard.php?hod_folder=<?php echo $selected_hod_folder; ?>&delete=" + fileName;
            }
        }
    </script>
</body>
</html>
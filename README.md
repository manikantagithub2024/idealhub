<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://static.vecteezy.com/system/resources/previews/023/308/048/non_2x/abstract-grey-metallic-overlap-on-dark-circle-mesh-pattern-design-modern-luxury-futuristic-background-vector.jpg'); /* Professional background image */
            background-size: cover; /* Ensures the image covers the entire background */
            background-position: center; /* Centers the background image */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column; /* Stack logo, welcome message, and login container vertically */
            position: relative; /* Required for absolute positioning of the settings icon */
        }
        .logo {
            width: 300px; /* Adjust the size of the logo */
            height: auto;
            margin-bottom: 20px; /* Space between logo and welcome message */
        }
        .welcome-message {
            font-size: 2.5em;
            color: #fff; /* White text for better visibility */
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adds shadow to text for better readability */
            font-weight: bold;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
            text-align: center;
            display: flex;
            gap: 20px; /* Space between login options */
        }
        .login-option {
            flex: 1; /* Equal width for all options */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: rgba(249, 249, 249, 0.9); /* Semi-transparent background */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
        }
        .login-option:hover {
            transform: translateY(-5px); /* Lift the card on hover */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
        }
        .login-option img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover; /* Ensures the image fits well */
        }
        .login-option h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }
        .login-option button {
            padding: 10px 20px;
            background-color: #020d18;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease; /* Smooth button hover effect */
        }
        .login-option button:hover {
            background-color: #0056b3;
        }
        /* Settings Icon (Admin Login) */
        .settings-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2em;
            color: #fff;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .settings-icon:hover {
            transform: rotate(90deg); /* Rotate the icon on hover */
        }
        /* Marquee styling */
        marquee {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
            color: #fff; /* White text */
            padding: 10px 0; /* Padding for better visibility */
            font-size: 1.2em; /* Larger text */
            font-weight: bold; /* Bold text */
            position: fixed; /* Fixed position at the top */
            top: 0; /* Align to the top */
            width: 100%; /* Full width */
            z-index: 1000; /* Ensure it's above other elements */
        }
    </style>
</head>
<body>
    <!-- Marquee Scrolling Text -->
    <marquee behavior="scroll" direction="left">
        Ideal Institute of Technology, Vidyut Nagar, Kakinada, NAAC A+, 90% Placements, Provided Courses: CSE, CSM, ECE, MECH, COS Approved by AICTE new Delhi,affliated by JNTUK Kakinada
    </marquee>

    <!-- Settings Icon (Admin Login) -->
    <div class="settings-icon" onclick="location.href='admin.html'">
        ⚙️
    </div>

    <!-- Logo -->
    <img src="https://www2.gasandairtech.co.uk/wp-content/uploads/2020/07/boiler-ideal-logo.png" alt="Logo" class="logo">

    

    <!-- Login Container -->
    <div class="login-container">
        <!-- Faculty Login -->
        <div class="login-option">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjB6z7YfHMHWS4kerjTrkfULw3nf9sKh2YGQ&s" alt="Faculty Image">
            <h2></h2>
            <button onclick="location.href='user_login.html'">Login</button>
        </div>
    </div>
</body>
</html>

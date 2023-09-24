<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimedia Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x: hidden; /* To prevent horizontal scrolling */
        }

        .container {
            max-width: 1000px; /* Increased max-width */
            padding-top:36%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        h1 {
            padding-top:10%;
            font-size: 28px;
            color: #007bff;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        .column {
            width: calc(50% - 10px); /* Two columns in one row */
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            height: 150px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .upload-button {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }

        }
        .code-link {
            margin-top:6%;
            padding-top:6%;
            
            color: blue; /* Set text color */
        }
    </style>
</head>
<body>
<div class="container">
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Include your database connection code here
        $conn = new mysqli("localhost", "root", "", "multimedia_data");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $title = $_POST["title"];
        $about = $_POST["about"];
        $video_path = "uploads/" . basename($_FILES["video"]["name"]);
        $image_path = "uploads/" . basename($_FILES["image"]["name"]);
        $pdf_path = "uploads/" . basename($_FILES["pdf"]["name"]);
        
        // Upload the video, image, and PDF files to the "uploads" folder
        move_uploaded_file($_FILES["video"]["tmp_name"], $video_path);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
        move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdf_path);
        
        // Insert multimedia data into the database
        $stmt = $conn->prepare("INSERT INTO multimedia_data (title, about, video, image, pdf) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $about, $video_path, $image_path, $pdf_path);
        
        if ($stmt->execute()) {
            echo "Multimedia data uploaded successfully!";
        } else {
            echo "Error uploading multimedia data: " . $conn->error;
        }
        
        $stmt->close();
        $conn->close();
    }
    ?>
<h1>Multimedia Upload</h1>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <div class="header"> <p>Visit the :  <a href="main.php" class="code-link">Home Page</a>.</p></div>
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>
    
    <label for="about">About:</label>
    <textarea name="about" id="about" required></textarea>

        <div class="row">
            <div class="column">
                <label for="video">Upload Video:</label>
                <input type="file" name="video" id="video" accept="video/*" required>
            </div>
            <div class="column">
                <label for="image">Upload Image:</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
        </div>

        <label for="pdf">Upload PDF:</label>
        <input type="file" name="pdf" id="pdf" accept=".pdf" required>

        <input type="submit" value="Upload" class="upload-button">
    </form>

    <br>
    <a href="view.php">Go to Multimedia Library</a>
</div>

<script>
    // Add animation to the upload button on page load
    const uploadButton = document.querySelector(".upload-button");
    uploadButton.addEventListener("animationiteration", () => {
        uploadButton.style.animation = "none";
        setTimeout(() => {
            uploadButton.style.animation = "pulse 2s infinite";
        }, 10);
    });
</script>

</body>
</html>

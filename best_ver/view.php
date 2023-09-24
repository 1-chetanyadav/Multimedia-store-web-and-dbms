<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view.css">
    <title><h1>Multimedia Library</h1></title>
 
</head>
<body>

    <div class="h11">
<div class="container">
    <h1>Multimedia Library</h1>

    <div class="upload-link">
        <a href="upload.php">Upload New Multimedia</a>
        <div class="header"> <p>Visit the :  <a href="main.php" class="code-link">Home Page</a>.</p></div>
    </div>
    </div>
    <div class="multimedia-list">
        <?php
        $conn = new mysqli("localhost", "root", "", "multimedia_data");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM multimedia_data";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="media-item">';
                
                echo '<h2>' . $row["title"] . '</h2>';
                
                echo '<p class="about">' . $row["about"] . '</p>';

                // Display image if available
                if (strpos($row["image"], ".jpg") !== false || strpos($row["image"], ".jpeg") !== false || strpos($row["image"], ".png") !== false) {
                    echo '<img src="' . $row["image"] . '" alt="Media Image" class="media-image">';
                }

                // Display video if available
                $file_extension = pathinfo($row["video"], PATHINFO_EXTENSION);
                if ($file_extension === "mp4") {
                    echo '<video src="' . $row["video"] . '" controls class="media-image"></video>';
                }

                // Display PDF link if available
                if (strpos($row["pdf"], ".pdf") !== false) {
                    echo '<div class="pdf-link"><a href="' . $row["pdf"] . '" target="_blank">View PDF</a></div>';
                }

                echo '</div>'; // Close media-item
            }
        } else {
            echo '<p>No multimedia items found.</p>';
        }

        $conn->close();
        ?>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company name</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="main">
       <div class="column1">
           
            <video id="video" width="300" height="200" autoplay></video>
            <button id="capture-btn">Capture</button>
            <canvas id="canvas" width="300" height="200"></canvas>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="image" id="image-data">
                <input type="submit" value="Upload" id="upload-btn" >
            </form>

    <?php
    date_default_timezone_set('Asia/Manila');
    $fname = date('F j, Y g:i:a  ');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if an image was submitted
        if (isset($_POST['image'])) {
            $imageData = $_POST['image'];
            // Remove the data URL scheme (e.g., "data:image/png;base64,")
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            // Decode the base64 image data
            $imageData = base64_decode($imageData);

            // Specify the directory and filename to save the image
            $uploadDir = 'uploads/';
            $filename = date('Y-m-d_H-i') . '.png';
            $targetFilePath = $uploadDir . $filename;

            // Save the image to the specified location
            if (file_put_contents($targetFilePath, $imageData)) {
                echo 'Image uploaded successfully!';
            } else {
                echo 'Error uploading image.';
            }
        }
    }
?>
       </div>

       <div class="column2">
            <form id="landing-form">
                
                <h1 id="date"></h1>
                <h2 id="clock"></h2>          
                <input type="text" id="username" name="username" placeholder="Employee ID" required>
                <button id="open-camera-btn">Open Camera</button>

                <select class="time">
                    <option disabled selected>Select Attendance</option>
                    <option value="time-in">Time In</option>
                    <option value="time-out">Time Out</option>
                </select>

               
              
                <button class="login-btn">SUBMIT</button>
            </form>
       </div>
    </div>

    
    <!-- JS -->
        <script>
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var captureButton = document.getElementById('capture-btn');
        var capturedImage = document.getElementById('captured-image');

        // Open the camera when the button is clicked
        document.getElementById('open-camera-btn').addEventListener('click', function () {
            // Access the webcam video stream
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();
                    captureButton.style.display = 'block';
                })
                .catch(function (error) {
                    console.log('Error accessing the webcam: ', error);
                });
        });

        // Capture the image from the video stream
        document.getElementById('capture-btn').addEventListener('click', function () {
            var video = document.getElementById('video');
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert the captured image to base64 data URL
            var imageData = canvas.toDataURL('image/png');
            document.getElementById('image-data').value = imageData;
        });


        function updateClock() {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            // Add leading zeros to minutes and seconds
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            // Format the time as HH:mm:ss
            var timeString = hours + ":" + minutes + ":" + seconds;

            // Get the current date
            var month = currentTime.getMonth() + 1;
            var day = currentTime.getDate();
            var year = currentTime.getFullYear();
            var dayOfWeek = currentTime.toLocaleDateString('en-US', { weekday: 'long' });
            var monthString = currentTime.toLocaleString('en-US', { month: 'long' });

            // Format the date as "Day, MM/DD/YYYY"
            var dateString = dayOfWeek + " — " + monthString + " "+ day + ", " + year;

            // Update the clock and date elements with the current time and date
            document.getElementById("clock").textContent = timeString;
            document.getElementById("date").textContent = dateString;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);
    </script>


    


    






</body>

</html>
<!DOCTYPE html>
<html>
<head>
    <title>Image Capture</title>
</head>
<body>
    <h1>Image Capture</h1>

    <video id="video" width="400" height="300" autoplay></video>
    <button id="capture-btn">Capture</button>
    <canvas id="canvas" width="400" height="300"></canvas>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="image" id="image-data">
        <input type="submit" value="Upload">
    </form>

    <script>
        // Access the webcam video stream
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                var video = document.getElementById('video');
                video.srcObject = stream;
                video.play();
            })
            .catch(function (error) {
                console.log('Error accessing the webcam: ', error);
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
    </script>

    <?php
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
            $filename = uniqid() . '.png';
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
</body>
</html>

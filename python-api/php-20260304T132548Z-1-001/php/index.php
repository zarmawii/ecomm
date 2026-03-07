<!DOCTYPE html>
<html>
<head>
    <title>Fruit Freshness Detection</title>
</head>
<body>

<h2>Fruit Freshness Detection</h2>

<!-- ================= FILE UPLOAD ================= -->
<h3>Upload Image</h3>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <button type="submit">Detect</button>
</form>

<hr>

<!-- ================= LIVE CAMERA ================= -->
<h3>Live Camera</h3>

<button onclick="startCamera()">Start Camera</button>
<button onclick="stopCamera()">Stop Camera</button>
<br><br>

<video id="video" width="400" autoplay playsinline></video>
<br><br>

<button id="captureBtn" onclick="capture()" style="display:none;">
    Capture & Detect
</button>

<canvas id="canvas" style="display:none;"></canvas>

<hr>

<h3 id="result"></h3>
<h4 id="confidence"></h4>

<script>

let stream = null;

// ================= FILE UPLOAD =================
document.getElementById("uploadForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("http://127.0.0.1:5001/predict", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => showResult(data))
    .catch(error => alert("Error: " + error));
});

// ================= START CAMERA =================
async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { width: 640, height: 480 }
        });

        const video = document.getElementById('video');
        video.srcObject = stream;

        video.onloadedmetadata = function () {
            video.play();
        };

        document.getElementById("captureBtn").style.display = "inline";

    } catch (error) {
        alert("Camera error: " + error.message);
        console.error(error);
    }
}

// ================= STOP CAMERA =================
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }

    const video = document.getElementById('video');
    video.srcObject = null;

    document.getElementById("captureBtn").style.display = "none";
}

// ================= CAPTURE =================
function capture() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    context.drawImage(video, 0, 0);

    canvas.toBlob(function(blob) {

        const formData = new FormData();
        formData.append("image", blob, "capture.jpg");

        fetch("http://127.0.0.1:5000/predict", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => showResult(data))
        .catch(error => alert("Error: " + error));

    }, "image/jpeg");
}

// ================= SHOW RESULT =================
function showResult(data) {
    if (data.result) {
        document.getElementById("result").innerHTML =
            "Result: " + data.result;

        document.getElementById("confidence").innerHTML =
            "Confidence: " + data.confidence.toFixed(2) + "%";
    } else {
        document.getElementById("result").innerHTML = "Error in prediction";
        document.getElementById("confidence").innerHTML = "";
    }
}

</script>

</body>
</html>
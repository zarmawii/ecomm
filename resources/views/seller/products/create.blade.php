@extends('layouts.seller')

@section('content')

<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-lg">

    <h2 class="text-2xl font-bold mb-4">Add Product</h2>

    <form method="POST"
          action="{{ route('seller.products.store') }}"
          enctype="multipart/form-data">

        @csrf

        <input type="text" name="name"
               placeholder="Product Name"
               class="w-full mb-3 border p-2" required>

        <select name="category"
                class="w-full mb-3 border p-2" required>
            <option value="">Select Category</option>
            <option value="vegetable">Vegetable</option>
            <option value="fruit">Fruit</option>
        </select>

        <input type="number" name="price"
               step="0.01"
               placeholder="Price"
               class="w-full mb-3 border p-2" required>

        <input type="number" name="stock"
               placeholder="Stock Quantity"
               class="w-full mb-3 border p-2" required>


        <!-- ================= CHOOSE METHOD ================= -->

        <h3 class="font-bold mt-4">Select Image Method</h3>

        <button type="button"
            onclick="showUpload()"
            class="bg-blue-500 text-white px-3 py-1 rounded">
            Upload Image
        </button>

        <button type="button"
            onclick="showCamera()"
            class="bg-purple-500 text-white px-3 py-1 rounded">
            Use Live Camera
        </button>


        <!-- ================= UPLOAD SECTION ================= -->

        <div id="uploadSection" class="mt-3 hidden">
            <input type="file"
                   name="image"
                   id="imageInput"
                   class="w-full border p-2"
                   accept="image/*">
        </div>


        <!-- ================= CAMERA SECTION ================= -->

        <div id="cameraSection" class="mt-3 hidden">

            <video id="video" width="400" autoplay playsinline class="border"></video>
            <br><br>

            <button type="button"
                onclick="capture()"
                class="bg-yellow-500 text-white px-3 py-1 rounded">
                Capture & Detect
            </button>

            <canvas id="canvas" class="hidden"></canvas>

        </div>


        <!-- AI RESULT -->
        <h4 id="result" class="mt-3 font-bold"></h4>
        <h5 id="confidence"></h5>


        <!-- SUBMIT -->
        <button id="submitBtn"
                class="bg-green-600 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed mt-4"
                disabled>
            Submit for Approval
        </button>

    </form>

</div>

<script>

let stream = null;

// Show Upload
function showUpload() {
    document.getElementById("uploadSection").classList.remove("hidden");
    document.getElementById("cameraSection").classList.add("hidden");
    stopCamera();
}

// Show Camera
async function showCamera() {
    document.getElementById("cameraSection").classList.remove("hidden");
    document.getElementById("uploadSection").classList.add("hidden");

    stream = await navigator.mediaDevices.getUserMedia({ video: true });
    document.getElementById("video").srcObject = stream;
}

// Stop Camera
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
}


// Run AI when upload changes
document.getElementById("imageInput")?.addEventListener("change", function() {
    if (this.files.length > 0) {
        runAI(this.files[0]);
    }
});


// Capture from camera
function capture() {

    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    context.drawImage(video, 0, 0);

    canvas.toBlob(function(blob) {

        // Put captured image into file input
        const file = new File([blob], "capture.jpg", { type: "image/jpeg" });
        const container = new DataTransfer();
        container.items.add(file);
        document.getElementById("imageInput").files = container.files;

        runAI(file);

    }, "image/jpeg");
}


// Common AI function
function runAI(file) {

    const formData = new FormData();
    formData.append("image", file);

    fetch("https://aipredict.onrender.com/predict", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        document.getElementById("result").innerHTML =
            "Result: " + data.result;

        document.getElementById("confidence").innerHTML =
            "Confidence: " + data.confidence.toFixed(2) + "%";

       if (data.result === "fresh") {
    enableSubmit();
    document.getElementById("result").innerHTML =
        "Result: fresh";
}

else if (data.result === "unknown") {
    disableSubmit();
    document.getElementById("result").innerHTML =
        "Result: unknown";
    alert("Unknown product. Only vegetables and fruits are allowed.");
}

else if (data.result === "Out of bound") {
    disableSubmit();
    document.getElementById("result").innerHTML =
        "Result: Out of bound";
    alert("Product not allowed. Only fresh vegetables or fruits.");
}

else {
    disableSubmit();
    alert("Product not fresh.");
}
    })
    .catch(error => alert("AI Server Error"));
}


function enableSubmit() {
    const btn = document.getElementById("submitBtn");
    btn.disabled = false;
    btn.classList.remove("opacity-50", "cursor-not-allowed");
}

function disableSubmit() {
    const btn = document.getElementById("submitBtn");
    btn.disabled = true;
    btn.classList.add("opacity-50", "cursor-not-allowed");
}

</script>

@endsection
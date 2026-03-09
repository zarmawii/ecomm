@extends('layouts.seller')

@section('content')

<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-lg">

```
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


    <!-- Hidden image input used for form submission -->
    <input type="file"
           name="image"
           id="imageInput"
           class="hidden"
           accept="image/*">


    <!-- ================= METHOD SELECT ================= -->

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


    <!-- ================= UPLOAD ================= -->

    <div id="uploadSection" class="mt-3 hidden">
        <input type="file"
               id="uploadPicker"
               class="w-full border p-2"
               accept="image/*">
    </div>


    <!-- ================= CAMERA ================= -->

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


    <!-- SUBMIT BUTTON -->
    <button id="submitBtn"
            class="bg-green-600 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed mt-4"
            disabled>
        Submit for Approval
    </button>

</form>
```

</div>

<script>

let stream = null;


// Show upload option
function showUpload() {
    document.getElementById("uploadSection").classList.remove("hidden");
    document.getElementById("cameraSection").classList.add("hidden");
    stopCamera();
}


// Show camera
async function showCamera() {

    document.getElementById("cameraSection").classList.remove("hidden");
    document.getElementById("uploadSection").classList.add("hidden");

    try {

        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        document.getElementById("video").srcObject = stream;

    } catch (err) {
        alert("Camera access denied");
    }
}


// Stop camera
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
}


// Upload detection
document.addEventListener("DOMContentLoaded", function() {

    const picker = document.getElementById("uploadPicker");

    picker.addEventListener("change", function(){

        const file = this.files[0];
        if(!file) return;

        const container = new DataTransfer();
        container.items.add(file);

        document.getElementById("imageInput").files = container.files;

        runAI(file);

    });

});


// Capture image
function capture() {

    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    context.drawImage(video,0,0);

    canvas.toBlob(function(blob){

        const file = new File([blob],"capture.jpg",{type:"image/jpeg"});

        const container = new DataTransfer();
        container.items.add(file);

        document.getElementById("imageInput").files = container.files;

        runAI(file);

    },"image/jpeg");

}


// AI detection
function runAI(file){

    const formData = new FormData();
    formData.append("image",file);

    fetch("https://aipredict.onrender.com/predict",{
        method:"POST",
        body:formData
    })

    .then(response=>{
        if(!response.ok){
            throw new Error("Server error "+response.status);
        }
        return response.json();
    })

    .then(data=>{

        document.getElementById("result").innerHTML =
            "Result: "+data.result;

        document.getElementById("confidence").innerHTML =
            "Confidence: "+data.confidence+"%";


        if(data.result==="fresh"){
            enableSubmit();
        }

        else if(data.result==="unknown"){
            disableSubmit();
            alert("Unknown product. Only fruits or vegetables allowed.");
        }

        else if(data.result==="Out of bound"){
            disableSubmit();
            alert("Product not allowed.");
        }

        else{
            disableSubmit();
            alert("Product not fresh.");
        }

    })

    .catch(error=>{
        console.error(error);
        alert("AI Server Error");
    });

}


// Enable submit
function enableSubmit(){
    const btn=document.getElementById("submitBtn");
    btn.disabled=false;
    btn.classList.remove("opacity-50","cursor-not-allowed");
}


// Disable submit
function disableSubmit(){
    const btn=document.getElementById("submitBtn");
    btn.disabled=true;
    btn.classList.add("opacity-50","cursor-not-allowed");
}

</script>

@endsection

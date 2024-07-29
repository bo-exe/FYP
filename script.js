// Navbar

function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}

// QR Scanner
let isScanning = false; // Flag to prevent multiple scans

function domReady(fn) {
    if (
        document.readyState === "complete" ||
        document.readyState === "interactive"
    ) {
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

domReady(function () {
    function onScanSuccess(decodedText) {
        if (isScanning) return; // Ignore scans if one is already in progress

        isScanning = true; // Set flag to true to prevent multiple scans
        const eventID = decodedText.trim();
        
        // Redirect to updatePoints.php with the eventID
        if (eventID) {
            window.location.href = `updatePoints.php?eventID=${eventID}`;
        }

        // Clear the QR code scanner and reset the flag
        html5QrcodeScanner.clear();
        isScanning = false;
    }

    // Ensure the QR scanner is initialized only once
    if (!window.htmlscanner) {
        window.htmlscanner = new Html5QrcodeScanner(
            "qr-scanner",
            { fps: 10, qrbox: 250 }
        );
        window.htmlscanner.render(onScanSuccess);
    }
});


//Slider Homepage
document.addEventListener('DOMContentLoaded', function () {
    const sliders = document.querySelectorAll('.slider-wrapper');

    sliders.forEach(wrapper => {
        const slider = wrapper.querySelector('.slider');
        const dots = wrapper.querySelectorAll('.dot');

        dots.forEach(dot => {
            dot.addEventListener('click', function () {
                const slideIndex = parseInt(this.getAttribute('data-slide'), 10) - 1;
                const slideWidth = slider.querySelector('img').clientWidth;
                slider.style.transform = `translateX(-${slideWidth * slideIndex}px)`;

                // Remove active class from all dots
                dots.forEach(d => d.classList.remove('active'));
                // Add active class to the clicked dot
                this.classList.add('active');
            });
        });
    });
});

// QR Code Generator
function generateQRCode() {
    var input = document.getElementById("qrInput").value;
    if (input.trim() === "") {
        alert("Please enter some text or a URL to generate the QR code.");
        return;
    }

    var qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(input)}&size=150x150`;
    document.getElementById("qrImage").src = qrCodeUrl;
}

// Existing JavaScript functions
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
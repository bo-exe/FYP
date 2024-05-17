// Navbar
function toggleMenu() {
    var navbar = document.querySelector('.navbar');
    navbar.classList.toggle('responsive');
}

// QR
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
 
    function onScanSuccess(decodeText, decodeResult) {
        alert("You Qr is : " + decodeText, decodeResult);  /* Tells you the message encoded in the QR code*/
        html5QrcodeScanner.clear(); /* QR Code Scanner closes after scanning a QR */
    }
 
    let htmlscanner = new Html5QrcodeScanner(
        "qr-scanner",
        { fps: 10, qrbos: 250 }
    );
    htmlscanner.render(onScanSuccess);
});
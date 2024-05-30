// Navbar

function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
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
 
    function onScanSuccess(decodedText) {
        window.location.href = decodedText;
        html5QrcodeScanner.clear(); /* QR Code Scanner closes after scanning a QR */
    }
 
    let htmlscanner = new Html5QrcodeScanner(
        "qr-scanner",
        { fps: 10, qrbos: 250 }
    );
    htmlscanner.render(onScanSuccess);
});

let slideIndex = [1, 1];
let slideId = ["carousel1", "carousel2"];
showSlides(1, 0);
showSlides(1, 1);

function plusSlides(n, no) {
    showSlides(slideIndex[no] += n, no);
}

function currentSlide(n, no) {
    showSlides(slideIndex[no] = n, no);
}

function showSlides(n, no) {
    let i;
    let x = document.querySelectorAll(`.carousel-container:nth-of-type(${no + 1}) .carousel img`);
    let dots = document.querySelectorAll(`.carousel-container:nth-of-type(${no + 1}) .dot`);
    if (n > x.length) { slideIndex[no] = 1 }
    if (n < 1) { slideIndex[no] = x.length }
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    x[slideIndex[no] - 1].style.display = "block";
    dots[slideIndex[no] - 1].className += " active";
}

function prevSlide(no) {
    plusSlides(-1, no);
}

function nextSlide(no) {
    plusSlides(1, no);
}

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



// var slideIndex = 1;
// showSlides(slideIndex);

// function plusSlides(n) {
//     showSlides(slideIndex += n);
// }

// function currentSlide(n) {
//     showSlides(slideIndex = n);
// }

// function showSlides(n) {
//     var i;
//     var slides = document.getElementsByClassName("mySlides");
//     var dots = document.getElementsByClassName("dot");
//     if (n > slides.length) {slideIndex = 1 }
//     if (n < 1) { slideIndex = slides.length }
//     for ( i = 0; i < slides.length; i++) {
//         slides[i].style.display = "none";
//     }
//     for (i = 0; i < dots.length; i++) {
//         dots[i].className = dots[i].className.replace(" active", "")
//     }
//     slides[slideIndex - 1].style.display = "block";
//     dots[slideIndex - 1].classname += "active";
//     }
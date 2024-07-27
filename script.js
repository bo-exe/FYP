// Navbar

function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}

// Function to check if the document is ready
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
    // Function to handle the successful scan
    function onScanSuccess(decodedText) {
        // Extract the number from the decodedText
        let eventID = parseInt(decodedText, 10);

        if (!isNaN(eventID)) {
            // Fetch the event details using the eventID
            fetchEventDetails(eventID)
                .then(points => {
                    if (points !== null) {
                        // Update the current user's points
                        updateUserPoints(points);
                    }
                })
                .catch(error => console.error('Error fetching event details:', error));
        } else {
            console.error('Invalid QR code data:', decodedText);
        }

        html5QrcodeScanner.clear(); // QR Code Scanner closes after scanning a QR
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

// Function to fetch event details using eventID
function fetchEventDetails(eventID) {
    return new Promise((resolve, reject) => {
        // Replace with your server endpoint
        fetch(`/getEventDetails.php?eventID=${eventID}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resolve(data.points);
                } else {
                    resolve(null);
                }
            })
            .catch(error => reject(error));
    });
}

// Function to update the current user's points
function updateUserPoints(points) {
    // Replace with your server endpoint and current user's volunteerId
    fetch(`/updateUserPoints.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ volunteerId: currentVolunteerId, points: points }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Points updated successfully');
            } else {
                console.error('Error updating points:', data.message);
            }
        })
        .catch(error => console.error('Error updating points:', error));
}


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

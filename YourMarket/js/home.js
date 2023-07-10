$(document).ready(function () {
    var currentIndex = 0;
    var images = $('.carousel-images img');
    var totalImages = images.length;

    // Show the first image
    images.eq(currentIndex).show();

    // Function to show the next image
    function showNextImage() {
        images.eq(currentIndex).hide();
        currentIndex = (currentIndex + 1) % totalImages;
        images.eq(currentIndex).fadeIn();
    }

    // Function to show the previous image
    function showPrevImage() {
        images.eq(currentIndex).hide();
        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
        images.eq(currentIndex).fadeIn();
    }

    // Auto-scroll the carousel
    setInterval(showNextImage, 3000); // Change the delay (in milliseconds) as per your requirement

    // Previous button click event
    $('.prev-button').click(function () {
        showPrevImage();
    });

    // Next button click event
    $('.next-button').click(function () {
        showNextImage();
    });
});


function updateQueryStringParameter(url, key, value) {
    var baseUrl = url.split('?')[0];
    var queryParams = url.split('?')[1];

    if (!queryParams) {
        return baseUrl + '?' + key + '=' + value;
    }

    var updatedParams = [];
    var params = queryParams.split('&');

    for (var i = 0; i < params.length; i++) {
        var param = params[i].split('=');
        if (param[0] === key) {
            param[1] = value;
        }
        updatedParams.push(param.join('='));
    }

    return baseUrl + '?' + updatedParams.join('&');
}
$(document).ready(function () {
    var currentIndex = 0;
    var images = $(".carousel-images img");
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
    $(".prev-button").click(function () {
        showPrevImage();
    });

    // Next button click event
    $(".next-button").click(function () {
        showNextImage();
    });

    // Filter buttons click event
    $("#filter-alphabet").click(function () {
        window.location.href = updateQueryStringParameter(window.location.href, "sort", "name");
    });

    $("#filter-price").click(function () {
        window.location.href = updateQueryStringParameter(window.location.href, "sort", "price");
    });

    // Function to update query string parameter
});

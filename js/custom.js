// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// owl carousel 

$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 6
        }
    }
})

$(document).ready(function(){
    // Scroll to section
    $('a.nav-link').on('click', function(event) {
        if (this.hash !== "") {
        event.preventDefault();
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 800, function(){
            window.location.hash = hash;
        });
        }
    });

    // Show or hide the back-to-top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
        $('#back-to-top').fadeIn();
        } else {
        $('#back-to-top').fadeOut();
        }
    });

    // Scroll to top
    $('#back-to-top').click(function() {
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
});


function addtocart(pid){
    let decodedCookie = decodeURIComponent(document.cookie);
    let cart = [];

    // Extract the cart cookie value
    let cartCookie = decodedCookie.split("; ").find(row => row.startsWith("cart="));
    
    if (cartCookie) {
        try {
            cart = JSON.parse(cartCookie.split("=")[1]);
        } catch (e) {
            console.error("Error parsing cart JSON:", e);
            cart = [];
        }
    }

    // Ensure cart is an array
    if (!Array.isArray(cart)) {
        cart = [];
    }

    // Add product ID to the cart
    cart.push(pid);
    document.cookie = "cart=" + encodeURIComponent(JSON.stringify(cart)) + "; path=/";

    alert("Product added to cart");
}

function removeFromCart(pid){
    let decodedCookie = decodeURIComponent(document.cookie);
    let cart = [];

    // Extract the cart cookie value
    let cartCookie = decodedCookie.split("; ").find(row => row.startsWith("cart="));
    
    if (cartCookie) {
        try {
            cart = JSON.parse(cartCookie.split("=")[1]);
        } catch (e) {
            console.error("Error parsing cart JSON:", e);
            cart = [];
        }
    }

    // Ensure cart is an array
    if (!Array.isArray(cart)) {
        cart = [];
    }

    // Remove product ID from the cart
    const index = cart.indexOf(pid);
    if (index > -1) {
        cart.splice(index, 1);
    }

    document.cookie = "cart=" + encodeURIComponent(JSON.stringify(cart)) + "; path=/";

    alert("Product removed from cart");
    window.location.reload();

}

document.addEventListener('DOMContentLoaded', function () {
    const photoRow = document.querySelector('.photo-gallery');
    console.log("Test 0")

    if (photoRow) {
        console.log("test")
        photoRow.addEventListener('click', function(event) {
            console.log(event.target.tagName.toLowerCase())
            if (event.target.tagName.toLowerCase() === 'button') {
                console.log('Button byl kliknut:', event.target);
            }
        });
    }

    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        initialSlide: 1,
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction'
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
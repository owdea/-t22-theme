document.addEventListener('DOMContentLoaded', function () {
    const photoRow = document.querySelector('.photo-gallery');
    const modalContainer = document.querySelector('.photo-gallery-modal');

    // Swiper init
    const swiper = new Swiper('.swiper', {
        direction: 'horizontal',
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction'
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // Event listener for img click
    if (photoRow) {
        photoRow.addEventListener('click', function(event) {
            if (event.target.tagName.toLowerCase() === 'button') {
                const pickedBtnIsMore = event.target.querySelector('.photo-more');
                let openLibrary = false
                if (pickedBtnIsMore) {
                    console.log(pickedBtnIsMore)
                    const displayValue = window.getComputedStyle(pickedBtnIsMore).display;
                    openLibrary = displayValue !== 'none'
                }

                modalContainer.style.display = 'flex';


                const pickedImg = event.target.id.slice(-1);

                swiper.slideTo(parseInt(pickedImg), 0);
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let adminBar = document.getElementById('wpadminbar');

    let adminBarHeight = adminBar ? adminBar.offsetHeight : 0;
    document.querySelector('.photo-gallery-modal').style.marginTop = adminBarHeight + 'px';

    let resizeObserver = new ResizeObserver(() => {
        let adminBarHeight = adminBar ? adminBar.offsetHeight : 0;
        document.querySelector('.photo-gallery-modal').style.marginTop = adminBarHeight + 'px';
    });

    if (adminBar) {
        resizeObserver.observe(adminBar);
    }
});
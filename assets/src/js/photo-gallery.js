//Todo: Po rozkliknutí obrázku to uvést do původního stavu (pro případ, že se galerie otevře, potom zavře a zase otevře)
document.addEventListener('DOMContentLoaded', function () {
    const photoRow = document.querySelector('.photo-gallery');
    const modalPhotoRow = document.querySelector('.modal-gallery')
    const modalContainer = document.querySelector('.photo-gallery-modal');
    const modalCloseButton = document.querySelector('.modal-header-close-button');
    const openLibraryButton = document.querySelector('.modal-header-library-button');
    const desktopModalSwiper = document.querySelector('.modal-desktop');
    const modalGallery = document.querySelector('.modal-gallery');
    const swiperPagination = document.querySelector('.swiper-pagination');
    let modalHeader = document.querySelector('.modal-header')
    let wasModalSwiperActive = false

    let resizeObserver = new ResizeObserver(() => {
        let modalWidth = modalHeader ? modalHeader.offsetWidth : 0
        if (modalWidth < 767 ) {
            desktopModalSwiper.style.display = "none";
            modalGallery.style.display = "flex";
            if (openLibraryButton) openLibraryButton.style.display = "none";
            if (swiperPagination) swiperPagination.style.display = "none";
        } else if (modalWidth >= 767 && wasModalSwiperActive) {
            desktopModalSwiper.style.display = "block";
            modalGallery.style.display = "none";
            if (openLibraryButton) openLibraryButton.style.display = "flex";
            if (swiperPagination) swiperPagination.style.display = "block";
        }
    })

    if (modalHeader) {
        resizeObserver.observe(modalHeader);
    }

    if (modalCloseButton && modalContainer) {
        modalCloseButton.addEventListener('click', function(event) {
            modalContainer.style.display = "none";
        })
    }

    if (openLibraryButton && desktopModalSwiper && modalGallery) {
        openLibraryButton.addEventListener('click', function(event) {
            modalGallery.style.display = "flex";
            desktopModalSwiper.style.display = "none";
            if (openLibraryButton) openLibraryButton.style.display = "none";
            if (swiperPagination) swiperPagination.style.display = "none";
            wasModalSwiperActive = false
        })
    }

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

    // Event listener for img click in modal gallery
    if (modalPhotoRow) {
        modalPhotoRow.addEventListener('click', function(event) {
            if (event.target.tagName.toLowerCase() === 'button') {
                const pickedImg = event.target.id.match(/\d+$/)[0];

                swiper.slideTo(parseInt(pickedImg), 0);
                desktopModalSwiper.style.display = "flex";
                modalGallery.style.display = "none";
                if (openLibraryButton) openLibraryButton.style.display = "flex";
                if (swiperPagination) swiperPagination.style.display = "block";
                wasModalSwiperActive = true
            }
        })
    }
    // Event listener for img click on article page
    if (photoRow) {
        photoRow.addEventListener('click', function(event) {
            if (event.target.tagName.toLowerCase() === 'button') {
                const pickedBtnIsMore = event.target.querySelector('.photo-more');
                let openLibrary = false
                if (pickedBtnIsMore) {
                    const displayValue = window.getComputedStyle(pickedBtnIsMore).display;
                    openLibrary = displayValue !== 'none'
                }
                if (openLibrary) {
                    modalGallery.style.display = "flex";
                    desktopModalSwiper.style.display = "none";
                    if (openLibraryButton) openLibraryButton.style.display = "none";
                    if (swiperPagination) swiperPagination.style.display = "none";
                } else {
                    modalGallery.style.display = "none"
                    desktopModalSwiper.style.display = "block";
                    if (openLibraryButton) openLibraryButton.style.display = "flex";
                    if (swiperPagination) swiperPagination.style.display = "block";
                    wasModalSwiperActive = true
                }

                modalContainer.style.display = 'flex';


                const pickedImg = event.target.id.slice(-1);

                swiper.slideTo(parseInt(pickedImg), 0);
            }
        });
    }
});

//Adding dynamic margins
document.addEventListener('DOMContentLoaded', function () {
    const adminBar = document.getElementById('wpadminbar');
    const modalHeader = document.querySelector('.modal-header');
    const desktopModalSwiper = document.querySelector('.modal-desktop');
    const modalGallery = document.querySelector('.modal-gallery');
    const modalContainer = document.querySelector('.photo-gallery-modal');

    // Getting height of the visible part of the adminBar
    const getVisibleHeight = (element) => {
        const rect = element.getBoundingClientRect();
        return Math.max(0, rect.bottom) - Math.max(0, rect.top);
    };

    let adminBarHeight = adminBar ? getVisibleHeight(adminBar) : 0;
    modalContainer.style.marginTop = adminBarHeight + 'px';

    let adminBarResizeObserver = new ResizeObserver(() => {
        let adminBarHeight = adminBar ? getVisibleHeight(adminBar) : 0;
        modalContainer.style.marginTop = adminBarHeight + 'px';
    });

    if (adminBar) {
        adminBarResizeObserver.observe(adminBar);
    }

    let headerResizeObserver = new ResizeObserver(() => {
        const headerHeight = modalHeader ? modalHeader.offsetHeight : 0;
        desktopModalSwiper.style.marginTop = headerHeight + 'px';
        modalGallery.style.marginTop = headerHeight + 'px';
    })

    if (modalHeader) {
        headerResizeObserver.observe(modalHeader);
    }

    // Update marginTop while strolling
    window.addEventListener('scroll', () => {
        let adminBarHeight = adminBar ? getVisibleHeight(adminBar) : 0;
        modalContainer.style.marginTop = adminBarHeight + 'px';
    });
});

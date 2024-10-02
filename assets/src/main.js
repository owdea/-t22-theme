document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('.secondary-menu-btn');
    const secondaryMenu = document.querySelector('.secondary-menu');

    if (menuButton && secondaryMenu) {
        menuButton.addEventListener('click', function () {
            secondaryMenu.classList.toggle('visibleBlock');
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const primaryMenuMobileButton = document.querySelector('.primary-menu-mobile-icon');
    const primaryMenuMobile = document.querySelector('.primary-menu-mobile');

    if (primaryMenuMobileButton && primaryMenuMobile) {
        primaryMenuMobileButton.addEventListener('click', function () {
            primaryMenuMobile.classList.toggle('visibleFlex');
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.querySelector('#mobile-search-bar-button');
    const searchLabel = document.querySelector('.header-top-right');
    const secondaryMenuButton = document.querySelector('.secondary-menu-btn');
    const headerLogo = document.querySelector('#header-logo')
    const magnifierIcon = document.querySelector('#mobile-search-magnifier')
    const exitIcon = document.querySelector('#mobile-search-exit')

    if (searchButton && searchLabel && secondaryMenuButton && headerLogo) {
        searchButton.addEventListener('click', function () {
            searchLabel.classList.toggle('header-top-right-mobile');
            secondaryMenuButton.classList.toggle('invisibleHidden');
            headerLogo.classList.toggle('invisibleHidden');
            magnifierIcon.classList.toggle('invisibleHidden');
            exitIcon.classList.toggle('visibleBlock');
        });
    }
})

document.addEventListener('DOMContentLoaded', function () {
    const moreButton = document.querySelector('.primary-more-btn');
    const primaryMoreMenu = document.querySelector('.primary-more');

    if (moreButton && primaryMoreMenu) {
        moreButton.addEventListener('click', function() {
            primaryMoreMenu.classList.toggle('visibleVisible')
            moreButton.classList.toggle('primary-button-active')
        })
    }
});

document.addEventListener("DOMContentLoaded", function() {
    document.fonts.ready.then(function() {
    const primaryMenuWidth = document.querySelector("#primary-menu");

    if (primaryMenuWidth) {
        const navigatorElement = document.getElementById('primary-navigator');
        const liveStreamElement = document.getElementById('primary-live');
        let navigatorWidth = 0;
        let liveStreamWidth = 0
        if (navigatorElement) navigatorWidth = navigatorElement.offsetWidth;
        if (liveStreamElement) liveStreamWidth = liveStreamElement.offsetWidth;
        let buttonPrimary = document.getElementById('primary-button').offsetWidth
        const primaryMenuWidthCounted = primaryMenuWidth.offsetWidth;

        let primaryElements = document.querySelectorAll('#primary-menu nav ul li');
        let primaryArray = Array.from(primaryElements);

        let primaryMoreArray = document.getElementById('primary-more');

        let widthSum = 0;

        for (let i = 0; i < primaryArray.length; i++) {
            if (navigatorWidth + liveStreamWidth + buttonPrimary + widthSum + primaryArray[i].offsetWidth > primaryMenuWidthCounted) {
                console.log({navigatorWidth: navigatorWidth, liveStreamWidth: liveStreamWidth})
                primaryMoreArray.append(primaryArray[i]);
                for (let j = i + 1; j < primaryArray.length; j++) {
                    primaryMoreArray.append(primaryArray[j]);
                }
                break;
            } else {
                widthSum += primaryArray[i].offsetWidth;
            }
        }

            const resize_ob = new ResizeObserver(function (entries) {
                let rect = entries[0].contentRect;
                let width = rect.width;

                // Získání aktuálních prvků z obou seznamů
                primaryArray = Array.from(document.querySelectorAll('#primary-menu nav ul li'));


                widthSum = 0;
                primaryArray.forEach(item => {
                    widthSum += item.offsetWidth;
                });

                // Znovu aktualizovat seznam prvků a šířku
                let primaryMoreElements = document.querySelectorAll('#primary-more li');
                let primaryMoreLiArray = Array.from(primaryMoreElements);
                let primaryHTMLElement = document.getElementById('primary-menu-ul'); // HTMLElement
                const navigatorElement = document.getElementById('primary-navigator');
                const liveStreamElement = document.getElementById('primary-live');
                if (navigatorElement) navigatorWidth = navigatorElement.offsetWidth;
                if (liveStreamElement) liveStreamWidth = liveStreamElement.offsetWidth;
                let buttonPrimary = document.getElementById('primary-button').offsetWidth;

                //Vytvoření neviditelného elementu pro sledování šířky prvního elementu se správnými styly
                const elementToDelete = document.querySelector('.primary-menu-more-first-item-duplicate');
                if (elementToDelete) {
                    elementToDelete.remove();
                }
                const originalElement = primaryMoreLiArray[0];
                const duplicateElement = originalElement.cloneNode(true);
                duplicateElement.className = '';
                duplicateElement.classList.add('primary-menu-more-first-item-duplicate');
                document.body.appendChild(duplicateElement);


                //Přesun do druhého pole
                if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimary > width) {
                    primaryMoreArray.prepend(primaryArray[primaryArray.length - 1]);
                } else if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimary + document.querySelector('.primary-menu-more-first-item-duplicate').offsetWidth <= width) {
                    primaryHTMLElement.append(primaryMoreLiArray[0]);
                }
            });


            resize_ob.observe(primaryMenuWidth);

    } else {
        console.error("Element s ID #primary-menu nebyl nalezen.");
    }
    })
});


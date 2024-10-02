// TODO: Hiding menu when changing res from mobile to wider.
// TODO: -> Delete !important even in those classes, watch width of the screen and use specific class for mobile res.
// TODO: Hide "Další..." button if there are not enough element to hide them
document.addEventListener('DOMContentLoaded', function () {
    // Event listener for toggling visibility of the secondary menu (top part of the header).
    const menuButton = document.querySelector('.secondary-menu-btn');
    const secondaryMenu = document.querySelector('.secondary-menu');

    if (menuButton && secondaryMenu) {
        menuButton.addEventListener('click', function () {
            secondaryMenu.classList.toggle('visibleBlock');
        });
    }


    // Event listener for toggling visibility of the mobile primary menu.
    // TODO: Hiding menu when changing res from mobile to wider.
    // TODO: -> Delete !important even in those classes, watch width of the screen and use specific class for mobile res.
    const primaryMenuMobileButton = document.querySelector('.primary-menu-mobile-icon');
    const primaryMenuMobile = document.querySelector('.primary-menu-mobile');

    if (primaryMenuMobileButton && primaryMenuMobile) {
        primaryMenuMobileButton.addEventListener('click', function () {
            primaryMenuMobile.classList.toggle('visibleFlex');
        });
    }


    // Event listener for toggling visibility of elements in case of opening mobile search menu.
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

    // Toggling "Další..." menu visibility on button click
    const moreButton = document.querySelector('.primary-more-btn');
    const primaryMoreMenu = document.querySelector('.primary-more');

    if (moreButton && primaryMoreMenu) {
        moreButton.addEventListener('click', function() {
            primaryMoreMenu.classList.toggle('visibleVisible')
            moreButton.classList.toggle('primary-button-active')
        })
    }

    // Handling changes in menu layout (visible menu and hidden elements in "Další..." menu
    document.fonts.ready.then(function() {
        // primaryMenu - whole bottom menu element (ul of navigators, chosen navigator (not required), live stream button (not required) and Další... button)
        // primaryMenuWidthCounted -
        // navigatorElement - chosen navigator | navigatorWidth - its width
        // liveStreamElement - live stream button | liveStreamWidth - its width
        // buttonPrimaryWidth - width of the "Další..." button
        // primaryElements - navigators NodeList from primary menu | primaryArray - JS array containing navigators from primary menu
        // primaryMoreArray - UL containing navigators which would not fit in #primary-menu
        const primaryMenu = document.querySelector("#primary-menu");

        if (primaryMenu) {
            const navigatorElement = document.getElementById('primary-navigator');
            const liveStreamElement = document.getElementById('primary-live');
            let navigatorWidth = 0;
            let liveStreamWidth = 0
            if (navigatorElement) navigatorWidth = navigatorElement.offsetWidth;
            if (liveStreamElement) liveStreamWidth = liveStreamElement.offsetWidth;
            let buttonPrimaryWidth = document.getElementById('primary-button').offsetWidth
            const primaryMenuWidthCounted = primaryMenu.offsetWidth;

            let primaryElements = document.querySelectorAll('#primary-menu nav ul li');
            let primaryArray = Array.from(primaryElements);

            let primaryMoreArray = document.getElementById('primary-more');

            let widthSum = 0;

            for (let i = 0; i < primaryArray.length; i++) {
                if (navigatorWidth + liveStreamWidth + buttonPrimaryWidth + widthSum + primaryArray[i].offsetWidth > primaryMenuWidthCounted) {
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

                    primaryArray = Array.from(document.querySelectorAll('#primary-menu nav ul li'));


                    widthSum = 0;
                    primaryArray.forEach(item => {
                        widthSum += item.offsetWidth;
                    });

                    // Refreshing lists of ULs and widths
                    // primaryMoreElements - LI NodeList containing current #primary-menu content
                    // primaryMoreLiArray - Array of the LI elements from #primary-menu
                    // primaryHTMLElement - HTMLElement containing #primary-menu for appending navigators in it
                    let primaryMoreElements = document.querySelectorAll('#primary-more li');
                    let primaryMoreLiArray = Array.from(primaryMoreElements);
                    let primaryHTMLElement = document.getElementById('primary-menu-ul');
                    const navigatorElement = document.getElementById('primary-navigator');
                    const liveStreamElement = document.getElementById('primary-live');
                    if (navigatorElement) navigatorWidth = navigatorElement.offsetWidth;
                    if (liveStreamElement) liveStreamWidth = liveStreamElement.offsetWidth;
                    let buttonPrimaryWidth = document.getElementById('primary-button').offsetWidth;

                    // Creating invisible element for watching width of the first element from hidden UL (copy of first LI with different styling).
                    // Deleting element which was created last time.
                    const elementToDelete = document.querySelector('.primary-menu-more-first-item-duplicate');
                    if (elementToDelete) {
                        elementToDelete.remove();
                    }
                    const originalElement = primaryMoreLiArray[0];
                    const duplicateElement = originalElement.cloneNode(true);
                    duplicateElement.className = '';
                    duplicateElement.classList.add('primary-menu-more-first-item-duplicate');
                    document.body.appendChild(duplicateElement);


                    //
                    if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimaryWidth > width) {
                        primaryMoreArray.prepend(primaryArray[primaryArray.length - 1]);
                    } else if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimaryWidth + document.querySelector('.primary-menu-more-first-item-duplicate').offsetWidth <= width) {
                        primaryHTMLElement.append(primaryMoreLiArray[0]);
                    }
            });


            resize_ob.observe(primaryMenu);

        } else {
            console.error("Element s ID #primary-menu nebyl nalezen.");
        }
    })
});


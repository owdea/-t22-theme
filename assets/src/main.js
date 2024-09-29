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
    const moreButton = document.querySelector('.primary-more-btn');
    const primaryMoreMenu = document.querySelector('.primary-more');

    if (moreButton && primaryMoreMenu) {
        moreButton.addEventListener('click', function() {
            primaryMoreMenu.classList.toggle('visibleVisible')
        })
    }
});

document.addEventListener("DOMContentLoaded", function() {
    document.fonts.ready.then(function() {
    const primaryMenuWidth = document.querySelector("#primary-menu");

    if (primaryMenuWidth) {
        let navigatorWidth = document.getElementById('primary-navigator').offsetWidth;
        let liveStreamWidth = document.getElementById('primary-live').offsetWidth;
        let buttonPrimary = document.getElementById('primary-button').offsetWidth
        const primaryMenuWidthCounted = primaryMenuWidth.offsetWidth;

        let primaryElements = document.querySelectorAll('#primary-menu nav ul li');
        let primaryArray = Array.from(primaryElements);

        let primaryMoreArray = document.getElementById('primary-more');

        let widthSum = 0;

        for (let i = 0; i < primaryArray.length; i++) {
            if (navigatorWidth + liveStreamWidth + buttonPrimary + widthSum + primaryArray[i].offsetWidth > primaryMenuWidthCounted) {
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
                let navigatorWidth = document.getElementById('primary-navigator').offsetWidth;
                let liveStreamWidth = document.getElementById('primary-live').offsetWidth;
                let buttonPrimary = document.getElementById('primary-button').offsetWidth

                //Přesun do druhého pole
                if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimary > width) {
                    primaryMoreArray.prepend(primaryArray[primaryArray.length - 1]);
                } else if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimary + primaryMoreLiArray[0].offsetWidth <= width) {
                    primaryHTMLElement.append(primaryMoreLiArray[0]);
                }
            });


            resize_ob.observe(primaryMenuWidth);

    } else {
        console.error("Element s ID #primary-menu nebyl nalezen.");
    }
    })
});


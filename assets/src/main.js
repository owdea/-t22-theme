document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('.secondary-menu-btn');
    const secondaryMenu = document.querySelector('.secondary-menu');

    if (menuButton && secondaryMenu) {
        menuButton.addEventListener('click', function () {
            secondaryMenu.classList.toggle('visible');
        });
    }
});



document.addEventListener("DOMContentLoaded", function() {
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
            } else {
                widthSum += primaryArray[i].offsetWidth;
            }
        }

        const resize_ob = new ResizeObserver(function(entries) {
            let rect = entries[0].contentRect;
            let width = rect.width;

            // Získání aktuálních prvků z obou seznamů
            primaryArray = Array.from(document.querySelectorAll('#primary-menu nav ul li'));
            primaryMoreElements = document.querySelectorAll('#primary-more li');
            primaryMoreLiArray = Array.from(primaryMoreElements);


            widthSum = 0;
            primaryArray.forEach(item => {
                widthSum += item.offsetWidth;
            });

            //Přesun do druhého pole
            if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimary + primaryArray[primaryArray.length - 1].offsetWidth > width) {
                primaryMoreArray.prepend(primaryArray[primaryArray.length - 1]);
                widthSum -= primaryArray[primaryArray.length - 1].offsetWidth
            }

            // Znovu aktualizovat seznam prvků a šířku
            primaryMoreElements = document.querySelectorAll('#primary-more li');
            primaryMoreLiArray = Array.from(primaryMoreElements);
            let primaryHTMLElement = document.getElementById('primary-menu-ul'); // HTMLElement


            //Přesun do prvního pole
            if (navigatorWidth + liveStreamWidth + widthSum + buttonPrimary + primaryMoreLiArray[0].offsetWidth <= width) {
                primaryHTMLElement.append(primaryMoreLiArray[0]);
                widthSum += primaryMoreLiArray[0].offsetWidth;
            }
        });


        resize_ob.observe(primaryMenuWidth);
    } else {
        console.error("Element s ID #primary-menu nebyl nalezen.");
    }
});


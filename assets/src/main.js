document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('.secondary-menu-btn');
    const secondaryMenu = document.querySelector('.secondary-menu');

    if (menuButton && secondaryMenu) {
        menuButton.addEventListener('click', function () {
            secondaryMenu.classList.toggle('visible');
        });
    }
});


//const menuWidth = document.getElementById('primary-menu').offsetWidth
document.addEventListener("DOMContentLoaded", function() {
    const primaryMenuWidth = document.querySelector("#primary-menu");

    if (primaryMenuWidth) {
        const resize_ob = new ResizeObserver(function(entries) {
            let rect = entries[0].contentRect;
            let width = rect.width;

            let navigatorWidth = document.getElementById('primary-navigator').offsetWidth;
            let liveStreamWidth = document.getElementById('primary-live').offsetWidth;

            let primaryElements = document.querySelectorAll('#primary-menu nav ul li'); // NodeList
            let primaryArray = Array.from(primaryElements); // Převod na pole
            let primaryHTMLElement = document.getElementById('primary-menu-ul'); // HTMLElement

            let primaryMoreArray = document.getElementById('primary-more'); // HTMLElement

            let widthSum = 0;

            // Přesun prvků do "více" menu, pokud se nevejdou
            for (let i = 0; i < primaryArray.length; i++) {
                if (navigatorWidth + liveStreamWidth + widthSum + primaryArray[i].offsetWidth > width) {
                    primaryMoreArray.prepend(primaryArray[i]); // Použij přímo primaryArray[i]
                } else {
                    widthSum += primaryArray[i].offsetWidth;
                }
            }

            // Získej aktualizovaný seznam prvků v secondary menu
            let primaryMoreElements = document.querySelectorAll('#primary-more li'); // NodeList
            let primaryMoreLiArray = Array.from(primaryMoreElements); // Pole

            // Ověření, že se nám první položka správně vrací
            if (navigatorWidth + liveStreamWidth + widthSum + primaryMoreLiArray[0].offsetWidth <= width) {
                console.log(primaryMoreArray[0]); // Zobrazí se správný prvek
                primaryHTMLElement.append(primaryMoreLiArray[0]);
            }
        });

        resize_ob.observe(primaryMenuWidth);
    } else {
        console.error("Element s ID #primary-menu nebyl nalezen.");
    }
});


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
            //console.log('Current Width : ' + width);
            let navigatorWidth = document.getElementById('primary-navigator').offsetWidth
            let liveStreamWidth = document.getElementById('primary-live').offsetWidth

            let primaryElements = document.querySelectorAll('#primary-menu nav ul li'); //NodeList - kolekce li elementů z viditelného UL
            let primaryArray = Array.from(primaryElements); //Array - pole li elementů vytvořené z NodeListu
            let primaryHTMLElement = document.getElementById('primary-menu-ul') //HTML Element

            let primaryMoreArray = document.getElementById('primary-more') //HTMLElement

            let widthSum = 0
            for (let i = 0; i < primaryArray.length; i++) {
                if (navigatorWidth + liveStreamWidth + widthSum + primaryArray[i].offsetWidth > width) {
                    primaryMoreArray.prepend(primaryElements[i])
                } else {
                    widthSum += primaryArray[i].offsetWidth
                }

            }
            let primaryMoreElements = document.querySelectorAll('#primary-menu-ul li'); //NodeList
            console.log("primaryMoreElements:" + primaryMoreElements);
            let primaryMoreLiArray = Array.from(primaryMoreElements); //Array - pole elementů
            console.log("PrimaryMoreLiArray:" + primaryMoreLiArray);

            for (let j = 0; j < primaryMoreLiArray.length; j++) {
                /*if (navigatorWidth + liveStreamWidth + widthSum + primaryMoreLiArray[j].offsetWidth <= width) {
                    primaryHTMLElement.append(primaryMoreLiArray[j]);
                    widthSum += primaryMoreLiArray[j].offsetWidth
                } else {

                }*/
            }
            console.log(widthSum)
        });
        resize_ob.observe(primaryMenuWidth);
    } else {
        console.error("Element s ID #primary-menu nebyl nalezen.");
    }
});

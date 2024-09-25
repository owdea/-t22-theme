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

            console.log('Current Width : ' + width);
        });

        resize_ob.observe(primaryMenuWidth);
    } else {
        console.error("Element s ID #primary-menu nebyl nalezen.");
    }
});

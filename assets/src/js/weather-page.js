document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".weather-days-row button");
    let activeIndex = 0;

    buttons.forEach((button, index) => {
        button.addEventListener("click", function () {
            const previousDataDivs = document.querySelectorAll(`.weather-data-${activeIndex + 1}`);
            previousDataDivs.forEach(div => {
                div.style.display = "none";
            });

            activeIndex = index;

            const selectedDataDivs = document.querySelectorAll(`.weather-data-${index + 1}`);
            selectedDataDivs.forEach(div => {
                div.style.display = "block";
            });
        });
    });
});

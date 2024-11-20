document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".weather-days-row button");
    let activeIndex = 1;

    buttons.forEach((button, index) => {
        const adjustedIndex = index + 1;
        button.addEventListener("click", function () {
            const previousDataDivs = document.querySelectorAll(`.weather-data-${activeIndex}`);
            previousDataDivs.forEach(div => {
                div.style.display = "none";
            });

            activeIndex = adjustedIndex;

            const selectedDataDivs = document.querySelectorAll(`.weather-data-${adjustedIndex}`);
            selectedDataDivs.forEach(div => {
                div.style.display = "block";
            });
        });
    });

    const initialDataDivs = document.querySelectorAll(".weather-data-1");
    initialDataDivs.forEach(div => {
        div.style.display = "block";
    });
});

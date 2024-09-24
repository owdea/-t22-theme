
const plugin = require("tailwindcss/plugin");
const colors = require("tailwindcss/colors");
/** @type {import('tailwindcss').Config} */
module.exports = {
    safelist: [
        'bg-transparent',
    ],
    content: [
        "./src/main.css",
        "./template-parts/**/*.php",
        "./index.php",
        "./header.php",
        "./footer.php",
        "./404.php"
    ],
    theme: {
        fontSize: {
            "3xs": ".75rem", //12px
            "2xs": ".875rem", //14px
            xs: "1rem", //16px
            sm: "1.125rem", //18px
            base: "1.25rem", //20px
            md: "1.313rem", //21px
            lg: "1.375rem", //22px
            xl: "1.75rem", //28px
            "2xl": "2.25rem", //36px
            "3xl": "2.625rem", //42px
        },
        colors: {
            lightscale: {
                20: '#ffffff',
            },
            bluescale: {
                60: "#007aff",
                80: "#00288c",
                100: "#003366",
            },
            darkscale: {
                40: "#6f6f6f",
                60: "#52556d",
                80: "#041e42",
                100: "#000528",
            },
        },
        fontFamily: {
            TV: ["TV Sans Screen", "sans-serif"],
            Source: ["Source Sans Pro", "sans-serif"]
        },
        extend: {
            backgroundImage: {
                'header-gradient': 'linear-gradient(90deg, rgb(1, 156, 225) 0%, rgb(0, 40, 140) 100%)',
            },
            // 414px, 522px (velikosti nadpisu náhledu článků), 767px, 992px (změna velikostí fotek), 1024px, 1200px
            screens: {
                'sm': '414px',
                'md': '522px',
                'tablet': '767px',
                'lg': '992px',
                'xl': '1024px',
                '2xl': '1200px',
            },
            backgroundColor: {
                ...colors
            },
            colors: {
                ...colors
            },
        },
    },
    plugins: [
        require("@tailwindcss/line-clamp")
    ],
}

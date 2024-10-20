
const plugin = require("tailwindcss/plugin");
const colors = require("tailwindcss/colors");
/** @type {import('tailwindcss').Config} */
module.exports = {
    safelist: [
        'bg-transparent',
        'visibleBlock',
        'primary-menu-container',
        'current-menu-item'
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
                5: '#cccdd4',
                10: '#E1E8FB',
                20: '#ffffff',
                40: '#f4f4f4',
                60: '#E0E0E0',

            },
            bluescale: {
                60: "#007aff",
                70: "#043CDC",
                80: "#00288c",
                100: "#003366",

            },
            darkscale: {
                40: "#6f6f6f",
                60: "#52556d",
                80: "#041e42", //rgba(4, 30, 66, 1);
                100: "#000528",
                120: "",
            },
            redscale: {
                40: "#ED1C1A",
                60: "#ed1c24",
            }
        },
        fontFamily: {
            TV: ["TV Sans Screen", "sans-serif"],
            Source: ["Source Sans Pro", "sans-serif"]
        },
        extend: {
            backgroundImage: {
                'blue-gradient': 'linear-gradient(90deg, rgb(1, 156, 225) 0%, rgb(0, 40, 140) 100%)',
                'black-gradient': 'linear-gradient(180deg, rgba(0, 0, 0, 0.12), rgba(0, 0, 0, 0.6))',
                'shadow-gradient': 'linear-gradient(180deg, transparent, rgba(0, 0, 0, 0.8))',
            },
            boxShadow: {
                'box-shadow': '0px 1px 3px rgba(0, 0, 0, 0.2), 0px 12px 24px -8px rgba(0, 0, 0, 0.15)',
            },
            // 414px, 522px (velikosti nadpisu náhledu článků), 767px, 992px (změna velikostí fotek), 1024px, 1200px
            screens: {
                'sm': '414px',
                'smd': '427px',
                '480': '480px',
                'md': '522px',
                'lmd': '610px',
                'stablet': '640px',
                'tablet': '767px',
                'lg': '992px',
                'xl': '1024px',
                '2xl': '1200px',
            },
            backgroundColor: {
                ...colors,
                'shadow-dark': 'rgba(0, 0, 0, 0.3);',
                'shadow-light': 'rgba(255, 255, 255, 0.08);',
                'gray-solid': 'rgba(244, 244, 244, 1);',
            },
            borderColor: {
                'white-transparent': 'rgba(255, 255, 255, 0.2)',
                'black-transparent': 'rgba(0, 0, 0, 0.2)',
            },
            colors: {
                ...colors,
                'navigator-green': "#228900"
            },
            gridTemplateColumns: {
                '2-auto': 'repeat(2, auto)',
            },
            gridTemplateRows: {
                '6-auto': 'repeat(6, auto)',
            },
        },
    },
    plugins: [
        require("@tailwindcss/line-clamp"),
        function({ addUtilities }) {
            addUtilities({
                '.transition-custom': {
                    transition: 'transform 10ms cubic-bezier(0, 0, 0.3, 1) 300ms, visibility 200ms cubic-bezier(0, 0, 0.3, 1), opacity 200ms cubic-bezier(0, 0, 0.3, 1)',
                },
            });
        },
    ],
}

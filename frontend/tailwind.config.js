/** @type {import('tailwindcss').Config} */
export default {
    content: [],
    theme: {
        extend: {
            animation: {
                'glowing-pulse':
                    'glowing-pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                'glowing-pulse': {
                    '0%, 100%': {
                        opacity: '1',
                        transform: 'scale(1.05)',
                        filter: 'blur(0px)',
                    },
                    '50%': {
                        opacity: '.5',
                        transform: 'scale(1)',
                        filter: 'blur(1.1px)',
                    },
                },
            },
        },
    },
    plugins: [],
    darkMode: 'class',
};

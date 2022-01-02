module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        colors: {
            'oceanic': '#212936',
            'oceanic-light': '#2b3648',
            'oceanic-lighter': '#455369',
            'gray-dark': '#7283a0',
            'gray': '#8490a2',
            'gray-light': '#afbdd1',
            'gray-lighter': '#97a3b9',
            'white': '#ffffff',
            'gray-lightest': '#cfd8e4',
            'red': '#d46363',
            'blue': '#1976d2',
            'blue-dark': '#11508e',
            'green': '#4caf50'
        },
        fontFamily: {
            'sans': ['Roboto', 'sans-serif']
        },
        extend: {
            fontSize: {
                'html-base': '16px',
                'html-tiny': '14px',
                'html-sm': '12px',
                'html-xs': '10px',
                '2xs': '0.625rem',
                '3': '0.75rem',
                '3.5': '0.87rem',
                '4': '1rem',
                '5': '1.25rem',
                '6': '1.5rem',
                '7': '1.75rem',
                '8': '2rem',
            },
            padding: {
                '18': '4.5rem',
                '1.25': '0.3125rem',
            },
            margin: {
                '18': '4.5rem'
            },
            height: {
                'full-screen': '100vh',
                'inherit': 'inherit',
                '13': '3.25rem',
            },
            maxHeight: {
                '70': '17.5rem',
            },
            width: {
                'full-screen': '100vw',
                'inherit': 'inherit',
                '13': '3.25rem'
            },
            flexBasis: {
                '68': '17rem'
            },
            borderRadius: {
                '50%': '50%'
            },
            gridTemplateColumns: {
                'departments': 'repeat(auto-fill, 23rem)'
            },
            backgroundColor: {
                'unset': 'unset',
                'popup': 'rgba(0, 0, 0, 0.35)'
            }
        },
    },
    plugins: [],
}

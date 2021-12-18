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
            'gray': '#8490a2',
            'gray-light': '#afbdd1',
            'white': '#ffffff',
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
            },
            padding: {
                '18': '4.5rem',
            },
            height: {
                'full-screen': '100vh',
                '100%': '100%',
            }
        },
    },
    plugins: [],
}

module.exports = {
    theme: {
        extend: {
            backgroundColor: {
                'primary': '#fafafa',
                'form': '#fbfbfd',
                'toggle-success': '#02e284',
            },
            borderColor: {
                'form': '#e7e8f1',
            },
        },
    },
    variants: {},
    plugins: [
        require('@tailwindcss/ui'),
    ],
}

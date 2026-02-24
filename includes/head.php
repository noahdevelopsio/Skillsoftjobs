<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>
    tailwind.config = {
    theme: {
        extend: {
        fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
        },
        colors: {
            brand: {
                50: '#f5f3ff',
                100: '#ede9fe',
                200: '#ddd6fe',
                300: '#c4b5fd',
                400: '#a78bfa',
                500: '#8b5cf6',
                600: '#7c3aed',
                700: '#6d28d9',
                800: '#5b21b6',
                900: '#4c1d95',
            }
        },
        animation: {
            'gradient-x': 'gradient-x 6s ease infinite',
        },
        keyframes: {
            'gradient-x': {
                '0%, 100%': { 'background-size': '200% 200%', 'background-position': 'left center' },
                '50%': { 'background-size': '200% 200%', 'background-position': 'right center' },
            },
        },
        }
    }
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/styles.css" />
<link rel="icon" type="image/png" href="/favicon.ico" />

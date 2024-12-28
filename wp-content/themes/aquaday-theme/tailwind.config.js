/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./header.php", "./front-page.php", "./footer.php", "./page.php", "./page-nosotros.php", "./page-categories.php", "./taxonomy-categoria_producto.php", "./single-producto.php", "./*.php", "./*/*.php"],
  theme: {   
    extend: {    
      fontWeight: {
        'ultralight': 100,
        'extralight': 200,
        'light': 300,
        'normal': 400,
        'medium': 500,
        'semibold': 600,
        'bold': 700,
        'black': 900,
      },
      screens: {
        'hd': '985px',
      }, 
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1' }],
      },
      colors: {
        bg:{
          primary: '#0181F5',
          secondary: '#0D2446',
          secondarysoft: '#143361',
          gray: '#FAFAFA'
        },
        texto: {
          primary: '#010F34',
          title: '#010F34',
          paragraph: '#788094',
          subtitle: '#0181F5',     // Color para texto normal
          link: '#212121',     // Color para enlaces
        },
      },
      fontFamily: {
        poppins: ['Poppins', 'serif'],
        sofia: ['Sofia Pro', 'sans-serif'],
      },
    },
  },
  plugins: [
  ],
}


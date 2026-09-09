/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/views/**/*.html',
        './resources/js/**/*.js',
    ],
    safelist: [
        // Dynamically composed classes (split across Blade interpolations) — see scan_out of storefront views
        'text-green-600', 'text-blue-600', 'text-amber-600',
        'border-green-100', 'border-blue-100', 'border-amber-100',
        // Cart / checkout-success dynamic color mapping
        'text-green-600', 'text-blue-600', 'text-amber-600',
        // About page "steps" & "sdgs" data-driven gradients
        'from-green-500', 'to-emerald-600',
        'from-emerald-500', 'to-teal-600',
        'from-teal-500', 'to-cyan-600',
        'from-cyan-500', 'to-sky-600',
        'from-red-500', 'to-rose-600',
        'from-blue-500', 'to-cyan-600',
        'ring-green-100', 'ring-emerald-100', 'ring-teal-100', 'ring-cyan-100',
        // Related-products hover scale (used inside interpolated class attributes)
        'group-hover:scale-130',
    ],
    theme: {
        extend: {
            colors: {
                green: {
                    950: '#03321f',
                },
            },
        },
    },
    plugins: [],
};
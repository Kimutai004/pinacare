# PINACARE Storefront Implementation TODO

## Controllers & Routes
- [x] Create `StorefrontController` (home, about, impact, community, partners, contact)
- [x] Create public `ShopController` (products index/show)
- [x] Create `CartController` (add/remove/update, cart page)
- [x] Create `CheckoutController` (checkout page, place order)
- [x] Add public blog show route (by slug)
- [x] Register storefront routes in `routes/web.php`

## Layout & Components
- [x] `storefront/layouts/app.blade.php` (navbar, footer, loader)
- [x] `storefront/partials/navbar.blade.php` (mobile-first, hamburger, cart count)
- [x] `storefront/partials/footer.blade.php`
- [x] `storefront/partials/loader.blade.php` (full-page eco loader — integrated in layout)

## Pages
- [x] Homepage (`storefront/index.blade.php`)
- [x] Shop/Products index (`storefront/products/index.blade.php`)
- [x] Product detail (`storefront/products/show.blade.php`)
- [x] About Us (`storefront/about.blade.php`)
- [x] Impact (`storefront/impact.blade.php`)
- [x] Community (`storefront/community.blade.php`)
- [x] Blog show (`storefront/blog/show.blade.php`)
- [x] Healthcare Partnerships (`storefront/partners.blade.php`)
- [x] Cart (`storefront/cart.blade.php`)
- [x] Checkout (`storefront/checkout.blade.php`)
- [x] Checkout Success (`storefront/checkout-success.blade.php`)
- [x] Contact (`storefront/contact.blade.php`)

## Testing
- [x] Create `StorefrontTest` feature test
- [x] All 13 storefront tests pass
- [x] Full suite passes (19 tests)


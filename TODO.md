# Admin Module Implementation TODO

## Foundations
- [x] Create missing `app/Models/Customer.php`
- [x] Create `subscriptions` migration
- [x] Add `admin` guard in `config/auth.php`
- [x] Create admin controllers

## Controllers
- [x] AdminAuthController (login/logout)
- [x] AdminController (dashboard, settings)
- [x] ProductController (CRUD + stock)
- [x] OrderController (index, show, update status)
- [x] SubscriptionController (index, update)
- [x] CustomerController (index)
- [x] ImpactController (index, metrics)
- [x] BlogController (CRUD + publish)
- [x] TestimonialController (approve/manage)

## Routes
- [x] Add admin routes to `routes/web.php`
- [x] Fix controller imports in `routes/api.php`

## Views
- [x] `layouts/app.blade.php` (sidebar + topbar shell)
- [x] `partials/sidebar.blade.php`
- [x] `partials/topbar.blade.php`
- [x] `auth/login.blade.php`
- [x] `dashboard/index.blade.php`
- [x] `products/index|create|edit.blade.php`
- [x] `orders/index|show.blade.php`
- [x] `subscriptions/index.blade.php`
- [x] `customers/index.blade.php`
- [x] `impact/index.blade.php`
- [x] `blog/index|create|edit.blade.php`
- [x] `testimonials/index.blade.php`
- [x] `settings/index.blade.php`

## Seeder
- [x] Update `DatabaseSeeder.php` with admin + sample data

## Model Fixes
- [x] Fix `OrderItem` model timestamps (table has no timestamps columns)

## Testing
- [x] Run migrations (all 14 succeeded)
- [x] Run seeder (admin + sample data seeded)
- [x] Verify admin routes (33 routes registered)
- [x] Fix dashboard Blade `@json` syntax error
- [x] Fix `Authenticate` middleware redirect for admin guard
- [x] Feature tests pass (dashboard, guest redirect, all pages render, product edit)

## Seeder Bug Fix
- [x] Rewrote `DatabaseSeeder.php` to be idempotent (no hardcoded IDs → uses model instances)
- [x] Removed stray XML `</content>` tag that caused PHP parse error
- [x] Ran `migrate:fresh` + `db:seed` successfully
- [x] Verified admin login works (`Hash::check('password') === true`)

## Feedback Changes
- [x] Made sidebar responsive on smaller devices with hamburger menu (off-canvas mobile drawer)
- [x] Removed gradient colors and replaced with single solid color blend throughout admin UI




<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ImpactMetric;
use App\Models\Product;
use App\Models\Testimonial;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StorefrontController extends Controller
{
    /**
     * Homepage: hero, highlights, featured products, impact counter, testimonials.
     */
    public function index()
    {
        $featuredProducts = Cache::remember('storefront.home.featured_products', 300, function () {
            return Product::where('is_active', true)->latest()->take(8)->get();
        });

        $productsByCat = Cache::remember('storefront.home.products_by_cat', 300, function () {
            return [
                'diaper' => Product::where('is_active', true)->where('category', 'diaper')->count(),
                'wipe'   => Product::where('is_active', true)->where('category', 'wipe')->count(),
                'bundle' => Product::where('is_active', true)->where('category', 'bundle')->count(),
            ];
        });

        $impact = Cache::remember('storefront.home.impact', 900, function () {
            return ImpactMetric::latest()->first();
        });

        $testimonials = Cache::remember('storefront.home.testimonials', 600, function () {
            return Testimonial::where('approved', true)->with('customer')->latest()->take(3)->get();
        });

        $posts = Cache::remember('storefront.home.posts', 600, function () {
            return BlogPost::whereNotNull('published_at')->latest()->take(3)->get();
        });

        return view('storefront.index', compact('featuredProducts', 'impact', 'testimonials', 'posts', 'productsByCat'));
    }

    /**
     * About Us page: story, vision & mission, live impact numbers and FAQs.
     */
    public function about()
    {
        $impact = Cache::remember('storefront.about.impact', 900, function () {
            return ImpactMetric::latest()->first();
        });

        // Single source of truth: rendered in the FAQ accordion AND used for FAQPage JSON-LD.
        $faqs = [
            [
                'q' => 'What are PINACARE diapers made from?',
                'a' => 'Pineapple leaf fibre. Leaves left over after the pineapple harvest are collected from local farms and processed into a soft, absorbent natural fibre without harmful chemicals, then crafted into our biodegradable diapers and wipes.',
            ],
            [
                'q' => 'Are PINACARE products safe for newborn skin?',
                'a' => 'Yes. Our range is dermatologist-tested, hypoallergenic and free from harsh chemicals, so it is gentle enough for delicate newborn skin and helps reduce the risk of nappy rash.',
            ],
            [
                'q' => 'What happens to a PINACARE diaper after use?',
                'a' => 'It is compostable. Because the materials are plant-based, a used diaper breaks down naturally and returns to the soil, completing the circular loop instead of sitting in a landfill.',
            ],
            [
                'q' => 'Where do you deliver and what does delivery cost?',
                'a' => 'Delivery is FREE within Nairobi. Other regions in Kenya and East Africa are charged a flat rate based on location.',
            ],
            [
                'q' => 'Can I have my order delivered every month?',
                'a' => 'Yes. Choose "Subscribe & Save" at checkout for automatic monthly deliveries at a 15% discount. You can pause or cancel anytime.',
            ],
            [
                'q' => 'How does PINACARE support farmers and the circular economy?',
                'a' => 'We buy pineapple leaves that would otherwise go to waste, pay fair wages and create green jobs for rural farming communities, then turn that agricultural waste into affordable, biodegradable baby care.',
            ],
            [
                'q' => 'How can my clinic, pharmacy or business partner with PINACARE?',
                'a' => 'We work with pediatricians, hospitals, maternal clinics and retailers across East Africa. Visit our Healthcare Partnerships page or contact our team to start a conversation.',
            ],
        ];

        $aboutUrl = route('store.about');

        $pageJsonLd = Seo::graph([
            [
                '@type'              => 'AboutPage',
                '@id'                => $aboutUrl . '#aboutpage',
                'url'                => $aboutUrl,
                'name'               => 'About PINACARE',
                'description'        => Seo::excerpt('PINACARE turns pineapple leaf fibre into 100% biodegradable, hypoallergenic baby diapers and wipes that protect babies, empower farmers and keep waste out of landfill.'),
                'isPartOf'           => ['@type' => 'WebSite', '@id' => request()->root() . '#website'],
                'about'              => ['@type' => 'Organization', '@id' => request()->root() . '#organization'],
                'primaryImageOfPage' => [
                    '@type' => 'ImageObject',
                    'url'   => Seo::absolute(asset('pinacare.jpeg')),
                ],
            ],
            [
                '@type'           => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => request()->root()],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => $aboutUrl],
                ],
            ],
            [
                '@type'      => 'FAQPage',
                '@id'        => $aboutUrl . '#faq',
                'mainEntity' => array_map(function (array $faq) {
                    return [
                        '@type'          => 'Question',
                        'name'           => $faq['q'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
                    ];
                }, $faqs),
            ],
        ]);

        return view('storefront.about', compact('impact', 'faqs', 'pageJsonLd'));
    }

    /**
     * Impact page.
     */
    public function impact()
    {
        $impact = Cache::remember('storefront.impact.latest', 900, function () {
            return ImpactMetric::latest()->first();
        });

        $metrics = Cache::remember('storefront.impact.metrics', 900, function () {
            return ImpactMetric::latest()->take(6)->get();
        });

        return view('storefront.impact', compact('impact', 'metrics'));
    }

    /**
     * Community page: blog posts, testimonials, newsletter (paginated).
     */
    public function community(Request $request)
    {
        $posts = BlogPost::whereNotNull('published_at')
            ->with('author')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $testimonials = Testimonial::where('approved', true)->with('customer')->latest()->get();

        return view('storefront.community', compact('posts', 'testimonials'));
    }

    /**
     * Healthcare Partnerships page.
     */
    public function partners()
    {
        return view('storefront.partners');
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        return view('storefront.contact');
    }

    /**
     * Newsletter signup (simple).
     */
    public function newsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        return back()->with('success', 'Thank you for subscribing to the PINACARE newsletter!');
    }
}


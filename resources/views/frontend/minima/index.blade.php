@extends('frontend.layouts.app')

@section('content')
<style>
    #section_featured .slick-slider .slick-list {
        background: #fff;
    }

    #flash_deal .slick-slider .slick-list .slick-slide,
    #section_featured .slick-slider .slick-list .slick-slide,
    #section_best_selling .slick-slider .slick-list .slick-slide,
    #section_newest .slick-slider .slick-list .slick-slide {
        margin-bottom: -5px;
    }

    .slider-card-section {
        filter: drop-shadow(0px 10px 30px rgba(0, 0, 0, 0.16));
    }

    @media (max-width: 991px) {
        #flash_deal .slick-slider .slick-list .slick-slide {
            margin-bottom: 0px;
        }

        .slider-card-section .container {
            min-width: auto !important;
        }
    }

    @media (max-width: 575px) {
        #section_featured .slick-slider .slick-list .slick-slide {
            margin-bottom: -4px;
        }
    }

    @media (min-width: 576px) {
        #section_featured .sm-gutters-15 {
            margin-left: -16px;
        }
    }

    @media (min-width: 768px) {
        .slider-card-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1;
        }
    }
</style>

<!-- Sliders -->
<div class="home-banner-area mb-3">
    <div class="p-0 position-relative">
        <!-- Sliders -->
        <div class="home-slider slider-full">
            @if (get_setting('home_slider_images', null, $lang) != null)
            <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-autoplay="true"
                data-infinite="true" data-fade="true" data-autoplay-speed="3000">
                @php
                $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
                $sliders = get_slider_images($decoded_slider_images);
                $home_slider_links = get_setting('home_slider_links', null, $lang);
                @endphp
                @foreach ($sliders as $key => $slider)
                <div class="carousel-box">
                    <a
                        href="{{ isset(json_decode($home_slider_links, true)[$key]) ? json_decode($home_slider_links, true)[$key] : '' }}">
                        <!-- Image -->
                        <style>
                            .img-fit {
                                object-fit: contain !important;
                                width: 100%;
                                height: 50%;
                                aspect-ratio: auto !important;
                            }
                        </style>
                        <div
                            class="d-block mw-100 img-fit overflow-hidden h-180px h-sm-200px h-md-250px h-lg-300px h-xl-370px">
                            <img class="img-fit w-100 h-100 has-transition ls-is-cached lazyloaded"
                                src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                alt="{{ env('APP_NAME') }} promo"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="slider-card-section">
            <div class="pt-4 pb-lg-4">
                <div class="container">
                    <div class="w-100 px-3 px-lg-0">
                        <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                            data-items="3" data-xxl-items="3" data-xl-items="3" data-lg-items="2" data-md-items="2"
                            data-sm-items="1.5" data-xs-items="1" data-arrows="true" data-dots="false">
                            <!-- Flash Deal -->
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ route('flash-deals') }}"
                                    class="d-block text-reset overflow-hidden position-relative">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset(get_setting('flash_deal_card_bg_image', null, $lang)) }}"
                                        alt="{{ env('APP_NAME') }} promo"
                                        class="img-fluid lazyload w-100 has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    <span class="position-absolute top-0 left-0 p-2rem d-flex flex-column"
                                        style="width: 70%">
                                        <span class="fs-30 fw-700 text-{{ get_setting('flash_deal_card_text') }}"
                                            style="text-transform: uppercase;">{{
                                            get_setting('flash_deal_card_bg_title') }}</span>
                                        <span class="fs-16 text-{{ get_setting('flash_deal_card_text') }}">{{
                                            get_setting('flash_deal_card_bg_subtitle') }}</span>
                                    </span>
                                </a>
                            </div>
                            <!-- Today's deal TODO -->
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ route('categories.all') }}"
                                    class="d-block text-reset overflow-hidden position-relative">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset(get_setting('todays_deal_card_bg_image', null, $lang)) }}"
                                        alt="{{ env('APP_NAME') }} promo"
                                        class="img-fluid lazyload w-100 has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    <span class="position-absolute top-0 left-0 p-2rem d-flex flex-column"
                                        style="width: 70%">
                                        <span class="fs-30 fw-700 text-{{ get_setting('flash_deal_card_text') }}"
                                            style="text-transform: uppercase;">{{
                                            get_setting('todays_deal_card_bg_title') }}</span>
                                        <span class="fs-16 text-{{ get_setting('flash_deal_card_text') }}">{{
                                            get_setting('todays_deal_card_bg_subtitle') }}</span>
                                    </span>
                                </a>
                            </div>
                            <!-- New Products -->
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ route('search', ['sort_by' => 'newest']) }}"
                                    class="d-block text-reset overflow-hidden position-relative">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset(get_setting('new_product_card_bg_image', null, $lang)) }}"
                                        alt="{{ env('APP_NAME') }} promo"
                                        class="img-fluid lazyload w-100 has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    <span class="position-absolute top-0 left-0 p-2rem d-flex flex-column"
                                        style="width: 70%">
                                        <span class="fs-30 fw-700 text-{{ get_setting('new_product_card_text') }}"
                                            style="text-transform: uppercase;">{{
                                            get_setting('new_product_card_bg_title') }}</span>
                                        <span class="fs-16 text-{{ get_setting('new_product_card_text') }}">{{
                                            get_setting('new_product_card_bg_subtitle') }}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

@if (count($featured_categories) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center position-relative">
                <span class="line-right"></span>
                <h3 class="text-center fs-16 fs-md-20 fw-700 mb-2 mb-sm-0 car-categories-title">
                    {{ translate('Featured Cars Categories') }}
                </h3>
                <span class="line-left"></span>
            </div>
            <br/>
            <!-- الفئات -->
            <div class="bg-white px-sm-3">
                <div class="swiper swiper-container-1">
                    <div class="swiper-wrapper">
                        @foreach ($featured_categories as $key => $category)
                            @if (isset($category->products) && $category->products->count() > 0)
                                @php
                                    $category_name = $category->getTranslation('name');
                                    $category_link = route('products.category', $category->slug);
                                @endphp
                                <div class="swiper-slide">
                                    <a href="{{ $category_link }}" class="text-decoration-none">
                                        <div class="carousel-box-1 position-relative p-1 has-transition-1 border">
                                            <div class="h-100 d-flex flex-column justify-content-between">
                                                <div class="position-relative hov-scale-img-1 overflow-hidden">
                                                    <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                        alt="{{ $category_name }}"
                                                        class="img-fit-1 w-100 h-100 has-transition-1"
                                                        style="aspect-ratio: 1/1;"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                                <div
                                                    class="w-100 d-flex align-items-center justify-content-center bg-overlay-1 text-center">
                                                    <span class="home-category-name-1 animate-underline-white fs-14 fw-600 text-white py-1 px-2 text-truncate">
                                                        {{ $category_name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- أزرار التنقل -->
                    <button type="button" class="custom-button-prev slick-arrow position-absolute"
                        aria-disabled="false">
                        <i class="las la-arrow-left"></i>
                    </button>
                    <button type="button" class="custom-button-next slick-arrow position-absolute"
                        aria-disabled="false">
                        <i class="las la-arrow-right"></i>
                    </button>
                    <!-- نقاط التنقل -->
                    <br />
                    <br />
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
@endif

<style>
    .car-categories-title {
        font-size: 2rem;
        font-weight: bold;
        color: black;
        position: relative;
        padding: 0 10px;
        transition: all 0.3s ease-in-out;
    }

    .car-categories-title:hover {
        color: #4a90e2; /* تأثير لون عند التمرير */
    }

   

    .swiper-slide {
        flex: 0 0 auto;
        width: 130px;
        /* حجم ثابت للشرائح */
        max-width: 150px;
        text-align: center;
    }

    .carousel-box-1 img {
        width: 100%;
        height: auto;
        object-fit: cover;
        aspect-ratio: 1/1;
    }

    .bg-overlay-1 {
        background-color: #007665;
        padding: 3px 0;
    }

    .has-transition-1 {
        transition: all 0.3s ease;
    }

    .hov-scale-img-1:hover {
        transform: scale(1.05);
    }

    .home-category-name-1 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.8rem;
        padding: 0 4px;
    }

    .swiper-wrapper {
        gap: 10px;
    }

    .custom-button-next,
    .custom-button-prev {
        width: 25px;
        height: 60px;
        background: rgb(177 174 174 / 30%) !important;
        border-radius: 0;
        color: #fff;
        box-shadow: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        border: none;
    }

    .custom-button-next {
        right: 10px;
    }

    .custom-button-prev {
        left: 10px;
    }

    .custom-button-next:hover,
    .custom-button-prev:hover {
        background-color: rgb(150 150 150 / 50%);
    }

    .aiz-carousel.arrow-x-15 .custom-button-next {
        right: 15px !important;
    }

    .aiz-carousel.arrow-dark .slick-arrow {
        width: 25px;
        height: 60px;
        background: rgb(177 174 174 / 30%) !important;
        border-radius: 0;
        color: #fff;
        box-shadow: none;
    }

    .aiz-carousel .custom-button-next {
        right: 10px;
    }

    .swiper-pagination {
        position: absolute;
        bottom: 10px;
        left: 0;
        width: 100%;
        text-align: center;
    }

    .swiper-pagination-bullet {
        background-color: #007665;
        width: 10px;
        height: 10px;
        margin: 0 5px;
        border-radius: 50%;
        opacity: 0.7;
    }

    .swiper-pagination-bullet-active {
        background-color: #005a4c;
        opacity: 1;
    }

    @media (max-width: 576px) {
        .home-category-name-1 {
            font-size: 0.7rem;
            /* تصغير حجم النص للأجهزة الصغيرة */
        }

        .custom-button-next,
        .custom-button-prev {
            width: 25px;
            height: 25px;
            font-size: 16px;
        }

        .swiper-slide {
            width: 110px;
            /* حجم ثابت للأجهزة الصغيرة */
            max-width: 110px;
        }
    }

    @media (max-width: 768px) {
        .home-category-name-1 {
            font-size: 0.75rem;
            /* تعديل حجم النص للأجهزة المتوسطة */
        }

        .swiper-slide {
            width: 120px;
            /* حجم ثابت للأجهزة المتوسطة */
            max-width: 120px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper-container-1', {
                direction: 'horizontal',
                loop: true, // لضمان التمرير المستمر
                slidesPerView: 'auto',
                spaceBetween: 10, // زيادة المسافة بين الشرائح
                centeredSlides: true, // لضمان التمركز
                navigation: {
                    nextEl: '.custom-button-next',
                    prevEl: '.custom-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                touchRatio: 1,
                grabCursor: true,
                breakpoints: {
                    1200: {
                        slidesPerView: 6,
                    },
                    992: {
                        slidesPerView: 5,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    576: {
                        slidesPerView: 3,
                    },
                },
            });
        });
</script>

<div style="text-align: center; font-family: 'Arial', sans-serif; font-size: 20px; font-weight: bold; color: #333; margin-bottom: 20px; transition: color 0.3s ease;">
    {{ translate('Click to get more cars') }}
</div>

<div style="display: flex; justify-content: space-between; gap: 10px; padding: 0 10px;">
    <a href="https://lakkta.com/category/Cars-for-rent-Hy50u" 
       class="hover-color" 
       style="flex: 1; padding: 12px 18px; font-size: 16px; text-align: center; 
              background: linear-gradient(135deg, #007665, #005a4d); 
              color: #fff; border: 2px solid transparent; 
              border-radius: 12px; 
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
              transition: all 0.3s ease;">
        <i class="fas fa-car" style="margin-right: 8px;"></i> {{ translate('Cars for rent') }}
    </a>
    <a href="{{ route('search', ['sort_by' => 'newest']) }}" 
       class="hover-color" 
       style="flex: 1; padding: 12px 18px; font-size: 16px; text-align: center; 
              background: linear-gradient(135deg, #007665, #005a4d); 
              color: #fff; border: 2px solid transparent; 
              border-radius: 12px; 
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
              transition: all 0.3s ease;">
        <i class="fas fa-search" style="margin-right: 8px;"></i> {{ translate('All Cars') }}
    </a>
</div>
<br>
<br>
<style>
 
    .hover-color {
        transition: all 0.3s ease-in-out;
    }

    .hover-color:hover {
        background: linear-gradient(135deg, #ff6600, #e65c00) !important; /* تدرج لوني عند الهوفر */
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2) !important;
    }
</style>
 
<!-- Banner section 1 -->
@php $homeBanner1Images = get_setting('home_banner1_images', null, $lang); @endphp
@if ($homeBanner1Images != null)
<div class="pb-2 pb-md-3 pt-2 pt-md-3">
    <div class="container mb-2 mb-md-3">
        @php
        $banner_1_imags = json_decode($homeBanner1Images);
        $data_md = count($banner_1_imags) >= 2 ? 2 : 1;
        $home_banner1_links = get_setting('home_banner1_links', null, $lang);
        @endphp
        <div class="w-100">
            <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                data-items="{{ count($banner_1_imags) }}" data-xxl-items="{{ count($banner_1_imags) }}"
                data-xl-items="{{ count($banner_1_imags) }}" data-lg-items="{{ $data_md }}"
                data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false">
                @foreach ($banner_1_imags as $key => $value)
                <div class="carousel-box overflow-hidden hov-scale-img">
                    <a href="{{ isset(json_decode($home_banner1_links, true)[$key]) ? json_decode($home_banner1_links, true)[$key] : '' }}"
                        class="d-block text-reset overflow-hidden">
                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                            data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                            class="img-fluid lazyload w-100 has-transition"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Featured Products -->
<div id="section_featured" class="">

</div>

<!-- Banner Section 2 -->
@php $homeBanner2Images = get_setting('home_banner2_images', null, $lang); @endphp
@if ($homeBanner2Images != null)
<div class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        @php
        $banner_2_imags = json_decode($homeBanner2Images);
        $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
        $home_banner2_links = get_setting('home_banner2_links', null, $lang);
        @endphp
        <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
            data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}"
            data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}" data-md-items="{{ $data_md }}"
            data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false">
            @foreach ($banner_2_imags as $key => $value)
            <div class="carousel-box overflow-hidden hov-scale-img">
                <a href="{{ isset(json_decode($home_banner2_links, true)[$key]) ? json_decode($home_banner2_links, true)[$key] : '' }}"
                    class="d-block text-reset overflow-hidden">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                        class="img-fluid lazyload w-100 has-transition"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="container">
    <div class="row">
        <div class="col-xl-6">
            <!-- Best Selling  -->
            <div id="section_best_selling">

            </div>
        </div>
        <div class="col-xl-6">
            <!-- New Products -->
            <div id="section_newest">

            </div>
        </div>
    </div>
</div>

<!-- Banner Section 3 -->
@php $homeBanner3Images = get_setting('home_banner3_images', null, $lang); @endphp
@if (get_setting('home_banner3_images') != null)
<div class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        @php
        $banner_3_imags = json_decode(get_setting('home_banner3_images', null, $lang));
        $data_md = count($banner_3_imags) >= 2 ? 2 : 1;
        $home_banner3_links = get_setting('home_banner3_links', null, $lang);
        @endphp
        <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
            data-items="{{ count($banner_3_imags) }}" data-xxl-items="{{ count($banner_3_imags) }}"
            data-xl-items="{{ count($banner_3_imags) }}" data-lg-items="{{ $data_md }}" data-md-items="{{ $data_md }}"
            data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false">
            @foreach ($banner_3_imags as $key => $value)
            <div class="carousel-box overflow-hidden hov-scale-img">
                <a href="{{ isset(json_decode($home_banner3_links, true)[$key]) ? json_decode($home_banner3_links, true)[$key] : '' }}"
                    class="d-block text-reset overflow-hidden">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                        class="img-fluid lazyload w-100 has-transition"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Auction Product -->
@if (addon_is_activated('auction'))
<div id="auction_products">

</div>
@endif

<!-- Category wise Products -->
<div id="section_home_categories">

</div>

<!-- Classified Product -->
@if (get_setting('classified_product') == 1)
@php
$classified_products = get_home_page_classified_products(6);
@endphp
@if (count($classified_products) > 0)
<section class="mb-2 mb-md-3 mt-3 mt-md-4 pt-1">
    <div class="container">
        <!-- Banner -->
        @php
        $classifiedBannerImage = get_setting('classified_banner_image', null, $lang);
        $classifiedBannerImageSmall = get_setting('classified_banner_image_small', null, $lang);
        @endphp
        @if (get_setting('classified_banner_image') != null || get_setting('classified_banner_image_small') != null)
        <div class="overflow-hidden hov-scale-img d-none d-md-block">
            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                data-src="{{ uploaded_asset($classifiedBannerImage) }}" alt="{{ env('APP_NAME') }} promo"
                class="lazyload img-fit h-100 has-transition"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
        </div>
        <div class="overflow-hidden hov-scale-img d-md-none">
            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                data-src="{{ $classifiedBannerImageSmall != null ? uploaded_asset($classifiedBannerImageSmall) : uploaded_asset($classifiedBannerImage) }}"
                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
        </div>
        @endif
        <div class="bg-white border p-3 p-sm-4">
            <!-- Top Section -->
            <div class="d-flex mb-3 mb-md-4 mt-2 align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('Classified Ads') }}</span>
                </h3>
                <!-- Links -->
                <div class="d-flex">
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                        href="{{ route('customer.products') }}">{{ translate('View All Products') }}</a>
                </div>
            </div>
            <!-- Products Section -->
            <div class="row no-gutters">
                @foreach ($classified_products as $key => $classified_product)
                <div class="col-xl-4 col-md-6 has-transition hov-shadow-out z-1">
                    <div class="aiz-card-box p-2 has-transition bg-white">
                        <div class="row hov-scale-img">
                            <div class="col-4 col-md-5 mb-3 mb-md-0">
                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                    class="d-block overflow-hidden h-auto h-md-150px text-center">
                                    <img class="img-fluid lazyload mx-auto has-transition"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ isset($classified_product->thumbnail->file_name) ? my_asset($classified_product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        alt="{{ $classified_product->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="fw-400 fs-14 text-dark text-truncate-2 lh-1-4 mb-3 h-35px d-none d-sm-block">
                                    <a href="{{ route('customer.product', $classified_product->slug) }}"
                                        class="d-block text-reset hov-text-primary">{{
                                        $classified_product->getTranslation('name') }}</a>
                                </h3>
                                <div class="fs-14 mb-3">
                                    <span class="text-secondary">{{ $classified_product->user ?
                                        $classified_product->user->name : '' }}</span><br>
                                    <span class="fw-700 text-primary">{{ single_price($classified_product->unit_price)
                                        }}</span>
                                </div>
                                @if ($classified_product->conditon == 'new')
                                <span class="badge badge-inline badge-soft-info fs-13 fw-700 px-3 py-2 text-info"
                                    style="border-radius: 20px;">{{ translate('New') }}</span>
                                @elseif($classified_product->conditon == 'used')
                                <span
                                    class="badge badge-inline badge-soft-secondary-base fs-13 fw-700 px-3 py-2 text-danger"
                                    style="border-radius: 20px;">{{ translate('Used') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@endif

<!-- Cupon -->
@if (get_setting('coupon_system') == 1)
<div class="mt-2 mt-md-3">
    <div class="container">
        <div class="position-relative py-5 px-3 px-sm-4 px-lg-5"
            style="background-color: {{ get_setting('cupon_background_color', '#292933') }}">
            <div class="text-center text-xl-left position-relative z-5">
                <div class="d-lg-flex justify-content-lg-between">
                    <div class="order-lg-1 mb-3 mb-lg-0">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="206.12" height="175.997" viewBox="0 0 206.12 175.997">
                            <defs>
                                <clipPath id="clip-path">
                                    <path id="Union_10" data-name="Union 10"
                                        d="M-.008,77.361l142.979-.327-22.578.051.176-77.132L143.148-.1l-.177,77.132-.064,28.218L-.072,105.58Z"
                                        transform="translate(0 0)" fill="none" stroke="#fff" stroke-width="2" />
                                </clipPath>
                            </defs>
                            <g id="Group_24326" data-name="Group 24326" transform="translate(-274.202 -5254.612)"
                                opacity="0.5">
                                <g id="Mask_Group_23" data-name="Mask Group 23"
                                    transform="translate(304.445 5355.902) rotate(-45)" clip-path="url(#clip-path)">
                                    <g id="Group_24322" data-name="Group 24322" transform="translate(7.681 5.856)">
                                        <g id="Subtraction_167" data-name="Subtraction 167" transform="translate(0 0)"
                                            fill="none">
                                            <path
                                                d="M127.451,90.3H8a8.009,8.009,0,0,1-8-8V60.2a14.953,14.953,0,0,0,10.642-4.408A14.951,14.951,0,0,0,15.05,45.15a14.953,14.953,0,0,0-4.408-10.643A14.951,14.951,0,0,0,0,30.1V8A8.009,8.009,0,0,1,8,0H127.451a8.009,8.009,0,0,1,8,8V29.79a15.05,15.05,0,1,0,0,30.1V82.3A8.009,8.009,0,0,1,127.451,90.3Z"
                                                stroke="none" />
                                            <path
                                                d="M 127.450813293457 88.30060577392578 C 130.75927734375 88.30060577392578 133.4509124755859 85.60896301269531 133.4509124755859 82.30050659179688 L 133.4508972167969 61.77521514892578 C 129.6533966064453 61.33430480957031 126.1383361816406 59.64068222045898 123.394172668457 56.89652252197266 C 120.1737594604492 53.67610168457031 118.4001998901367 49.39426422119141 118.4001998901367 44.83980178833008 C 118.4001998901367 40.28572463989258 120.1737747192383 36.0041618347168 123.3942184448242 32.78384399414062 C 126.1376495361328 30.04052734375 129.6527099609375 28.34706115722656 133.4509124755859 27.9056282043457 L 133.4509124755859 8.000102996826172 C 133.4509124755859 4.691642761230469 130.75927734375 2.000002861022949 127.450813293457 2.000002861022949 L 8.000096321105957 2.000002861022949 C 4.691636085510254 2.000002861022949 1.999996185302734 4.691642761230469 1.999996185302734 8.000102996826172 L 1.999996185302734 28.21491050720215 C 5.797210216522217 28.65582466125488 9.31190013885498 30.34944725036621 12.05595588684082 33.09362411499023 C 15.27627658843994 36.31408309936523 17.04979705810547 40.59588241577148 17.04979705810547 45.15030288696289 C 17.04979705810547 49.70434188842773 15.27627658843994 53.98588180541992 12.05591583251953 57.20624160766602 C 9.312583923339844 59.94955825805664 5.797909259796143 61.64302062988281 1.999996185302734 62.08445739746094 L 1.999996185302734 82.30050659179688 C 1.999996185302734 85.60896301269531 4.691636085510254 88.30060577392578 8.000096321105957 88.30060577392578 L 127.450813293457 88.30060577392578 M 127.450813293457 90.30060577392578 L 8.000096321105957 90.30060577392578 C 3.588836193084717 90.30060577392578 -3.762207143154228e-06 86.71176147460938 -3.762207143154228e-06 82.30050659179688 L -3.762207143154228e-06 60.20010375976562 C 4.022176265716553 60.19910430908203 7.799756050109863 58.63396453857422 10.64171600341797 55.79202270507812 C 13.48431587219238 52.94942474365234 15.04979610443115 49.17012405395508 15.04979610443115 45.15030288696289 C 15.04979610443115 41.13010406494141 13.48431587219238 37.35052108764648 10.64171600341797 34.5078010559082 C 7.799176216125488 31.66514205932617 4.019876003265381 30.0996036529541 -3.762207143154228e-06 30.0996036529541 L -3.762207143154228e-06 8.000102996826172 C -3.762207143154228e-06 3.588842868804932 3.588836193084717 2.886962874981691e-06 8.000096321105957 2.886962874981691e-06 L 127.450813293457 2.886962874981691e-06 C 131.8620758056641 2.886962874981691e-06 135.4509124755859 3.588842868804932 135.4509124755859 8.000102996826172 L 135.4509124755859 29.79000282287598 C 131.4283294677734 29.79100227355957 127.6504745483398 31.35614204406738 124.8083953857422 34.19808197021484 C 121.9657363891602 37.04064178466797 120.4001998901367 40.81994247436523 120.4001998901367 44.83980178833008 C 120.4001998901367 48.86006164550781 121.9657363891602 52.63964462280273 124.8083953857422 55.48230361938477 C 127.6510543823242 58.3249626159668 131.4306488037109 59.8905029296875 135.4508972167969 59.8905029296875 L 135.4509124755859 82.30050659179688 C 135.4509124755859 86.71176147460938 131.8620758056641 90.30060577392578 127.450813293457 90.30060577392578 Z"
                                                stroke="none" fill="#fff" />
                                        </g>
                                    </g>
                                </g>
                                <g id="Group_24321" data-name="Group 24321"
                                    transform="translate(274.202 5357.276) rotate(-45)">
                                    <g id="Subtraction_167-2" data-name="Subtraction 167" transform="translate(0 0)"
                                        fill="none">
                                        <path
                                            d="M127.451,90.3H8a8.009,8.009,0,0,1-8-8V60.2a14.953,14.953,0,0,0,10.642-4.408A14.951,14.951,0,0,0,15.05,45.15a14.953,14.953,0,0,0-4.408-10.643A14.951,14.951,0,0,0,0,30.1V8A8.009,8.009,0,0,1,8,0H127.451a8.009,8.009,0,0,1,8,8V29.79a15.05,15.05,0,1,0,0,30.1V82.3A8.009,8.009,0,0,1,127.451,90.3Z"
                                            stroke="none" />
                                        <path
                                            d="M 127.450813293457 88.30060577392578 C 130.75927734375 88.30060577392578 133.4509124755859 85.60896301269531 133.4509124755859 82.30050659179688 L 133.4508972167969 61.77521514892578 C 129.6533966064453 61.33430480957031 126.1383361816406 59.64068222045898 123.394172668457 56.89652252197266 C 120.1737594604492 53.67610168457031 118.4001998901367 49.39426422119141 118.4001998901367 44.83980178833008 C 118.4001998901367 40.28572463989258 120.1737747192383 36.0041618347168 123.3942184448242 32.78384399414062 C 126.1376495361328 30.04052734375 129.6527099609375 28.34706115722656 133.4509124755859 27.9056282043457 L 133.4509124755859 8.000102996826172 C 133.4509124755859 4.691642761230469 130.75927734375 2.000002861022949 127.450813293457 2.000002861022949 L 8.000096321105957 2.000002861022949 C 4.691636085510254 2.000002861022949 1.999996185302734 4.691642761230469 1.999996185302734 8.000102996826172 L 1.999996185302734 28.21491050720215 C 5.797210216522217 28.65582466125488 9.31190013885498 30.34944725036621 12.05595588684082 33.09362411499023 C 15.27627658843994 36.31408309936523 17.04979705810547 40.59588241577148 17.04979705810547 45.15030288696289 C 17.04979705810547 49.70434188842773 15.27627658843994 53.98588180541992 12.05591583251953 57.20624160766602 C 9.312583923339844 59.94955825805664 5.797909259796143 61.64302062988281 1.999996185302734 62.08445739746094 L 1.999996185302734 82.30050659179688 C 1.999996185302734 85.60896301269531 4.691636085510254 88.30060577392578 8.000096321105957 88.30060577392578 L 127.450813293457 88.30060577392578 M 127.450813293457 90.30060577392578 L 8.000096321105957 90.30060577392578 C 3.588836193084717 90.30060577392578 -3.762207143154228e-06 86.71176147460938 -3.762207143154228e-06 82.30050659179688 L -3.762207143154228e-06 60.20010375976562 C 4.022176265716553 60.19910430908203 7.799756050109863 58.63396453857422 10.64171600341797 55.79202270507812 C 13.48431587219238 52.94942474365234 15.04979610443115 49.17012405395508 15.04979610443115 45.15030288696289 C 15.04979610443115 41.13010406494141 13.48431587219238 37.35052108764648 10.64171600341797 34.5078010559082 C 7.799176216125488 31.66514205932617 4.019876003265381 30.0996036529541 -3.762207143154228e-06 30.0996036529541 L -3.762207143154228e-06 8.000102996826172 C -3.762207143154228e-06 3.588842868804932 3.588836193084717 2.886962874981691e-06 8.000096321105957 2.886962874981691e-06 L 127.450813293457 2.886962874981691e-06 C 131.8620758056641 2.886962874981691e-06 135.4509124755859 3.588842868804932 135.4509124755859 8.000102996826172 L 135.4509124755859 29.79000282287598 C 131.4283294677734 29.79100227355957 127.6504745483398 31.35614204406738 124.8083953857422 34.19808197021484 C 121.9657363891602 37.04064178466797 120.4001998901367 40.81994247436523 120.4001998901367 44.83980178833008 C 120.4001998901367 48.86006164550781 121.9657363891602 52.63964462280273 124.8083953857422 55.48230361938477 C 127.6510543823242 58.3249626159668 131.4306488037109 59.8905029296875 135.4508972167969 59.8905029296875 L 135.4509124755859 82.30050659179688 C 135.4509124755859 86.71176147460938 131.8620758056641 90.30060577392578 127.450813293457 90.30060577392578 Z"
                                            stroke="none" fill="#fff" />
                                    </g>
                                    <g id="Group_24325" data-name="Group 24325" transform="translate(26.233 43.075)">
                                        <path id="Path_41600" data-name="Path 41600"
                                            d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z"
                                            transform="translate(22.575 0.058)" fill="#fff" />
                                        <path id="Path_41601" data-name="Path 41601"
                                            d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z"
                                            transform="translate(45.151 0.006)" fill="#fff" />
                                        <path id="Path_41602" data-name="Path 41602"
                                            d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z"
                                            transform="translate(67.725 -0.046)" fill="#fff" />
                                        <path id="Path_41603" data-name="Path 41603"
                                            d="M.006.024,15.056-.01l-.009,3.763L0,3.787Z" transform="translate(0 0.11)"
                                            fill="#fff" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div class="">
                        <h5 class="fs-36 fw-400 text-white mb-3">{{ translate(get_setting('cupon_title')) }}</h5>
                        <h5 class="fs-20 fw-400 text-white">{{ translate(get_setting('cupon_subtitle')) }}</h5>
                        <div class="mt-5">
                            <a href="{{ route('coupons.all') }}"
                                class="btn text-white hov-bg-white hov-text-dark fs-16 px-5"
                                style="border-radius: 28px;background: rgba(255, 255, 255, 0.2);box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.16);">{{
                                translate('View All Coupons') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container mt-2 mt-md-3 mb-2 mb-md-3 pb-4">
    <div class="row">
        <div class="col-xl-6 py-3 py-xl-0">
            <!-- Top Sellers -->
            @if (get_setting('vendor_system_activation') == 1)
                @php
                    $best_selers = get_best_sellers(10);
                @endphp
                @if (count($best_selers) > 0)
                    <section class="mt-2 mt-md-3 border h-100">
                        <div class="p-4">
                            <!-- Top Section -->
                            <div class="d-flex mb-3 mb-md-4 align-items-baseline justify-content-between">
                                <!-- Title -->
                                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                    <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                </h3>
                                <!-- Links -->
                                <div class="d-flex">
                                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                        href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                </div>
                            </div>
                            <!-- Sellers Section -->
                            <div class="aiz-carousel arrow-x-0 arrow-inactive-none" 
                            data-rows="2" 
                            data-items="5"
                            data-xxl-items="5" 
                            data-xl-items="4" 
                            data-lg-items="4" 
                            data-md-items="3.5" 
                            data-sm-items="3" 
                            data-xs-items="2.5" 
                            data-arrows="true" 
                            data-dots="false">
                                @foreach ($best_selers as $key => $seller)
                                    @if ($seller->user != null && isset($seller->user->products) && $seller->user->products->count() > 0)
                                        <div
                                            class="carousel-box h-100 position-relative text-center has-transition hov-animate-outline">
                                            <div class="position-relative px-2 py-2">
                                                <!-- Shop logo & Verification Status -->
                                                <div class="mx-auto size-80px">
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="d-flex mx-auto justify-content-center align-item-center size-80px border overflow-hidden hov-scale-img"
                                                        tabindex="0"
                                                        style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.06);">
                                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                            data-src="{{ uploaded_asset($seller->logo) }}" alt="{{ $seller->name }}"
                                                            style="height: auto !important; width: auto !important; aspect-ratio: 1 / 1 !important; object-fit: cover !important"
                                                            class="img-fit lazyload has-transition"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                    </a>
                                                </div>
                                                <!-- Shop name -->
                                                <h2 class="fs-12 fw-700 text-dark text-truncate-2 h-30px mt-2 mb-2">
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="text-reset hov-text-primary" tabindex="0">{{ $seller->name }}</a>
                                                </h2>
                                                <!-- Shop Rating -->
                                                <div class="rating rating-mr-2 text-dark mb-2">
                                                    {{ renderStarRating($seller->rating) }}
                                                    <span class="opacity-60 fs-12">({{ $seller->num_of_reviews }} {{ translate('Reviews') }})</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        </div>
        

        <div class="col-xl-6 py-3 py-xl-0">
            <!-- Top Brands -->
            @if (get_setting('top_brands') != null)
                <section class="mt-2 mt-md-3 border h-100">
                    <div class="p-4">
                        <!-- Top Section -->
                        <div class="d-flex mb-3 mb-md-4 align-items-baseline justify-content-between">
                            <!-- Title -->
                            <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">{{ translate('Top Brands') }}</h3>
                            <!-- Links -->
                            <div class="d-flex">
                                <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                    href="{{ route('brands.all') }}">{{ translate('View All Brands') }}</a>
                            </div>
                        </div>
                        <!-- Brands Section -->
                        <div class="aiz-carousel arrow-x-0 arrow-inactive-none" 
                        data-rows="2" 
                        data-items="5"
                        data-xxl-items="5" 
                        data-xl-items="4" 
                        data-lg-items="4" 
                        data-md-items="3.5" 
                        data-sm-items="3" 
                        data-xs-items="2.5" 
                        data-arrows="true" 
                        data-dots="false">
                            @php
                                $top_brands = json_decode(get_setting('top_brands'));
                                $brands = get_brands($top_brands);
                            @endphp
                            @foreach ($brands as $brand)
                                <div class="carousel-box position-relative text-center hov-scale-img has-transition hov-shadow-out z-1">
                                    <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-2">
                                        <img src="{{ $brand->logo != null ? uploaded_asset($brand->logo) : static_asset('assets/img/placeholder.jpg') }}"
                                            class="lazyload h-80px h-md-100px mx-auto has-transition p-2 p-sm-4"
                                            alt="{{ $brand->getTranslation('name') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        <p class="text-center text-dark fs-12 fs-md-14 fw-700 mt-2 mb-2 text-truncate"
                                            title="{{ $brand->getTranslation('name') }}">
                                            {{ $brand->getTranslation('name') }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
    <script>
        @media (max-width: 768px) {
            .aiz-carousel .carousel-box img {
                height: 60px; 
            }
        }

        /* تحسين العرض للشاشات الصغيرة */
@media (max-width: 1200px) {
    .carousel-box .size-100px {
        width: 80px;
        height: 80px;
    }

    .carousel-box h2 {
        font-size: 13px;
    }

    .carousel-box .rating {
        font-size: 12px;
    }
}

@media (max-width: 768px) {
    .carousel-box .size-100px {
        width: 70px;
        height: 70px;
    }

    .carousel-box h2 {
        font-size: 12px;
    }

    .carousel-box .rating {
        font-size: 11px;
    }
}

@media (max-width: 576px) {
    .carousel-box .size-100px {
        width: 60px;
        height: 60px;
    }

    .carousel-box h2 {
        font-size: 11px;
    }

    .carousel-box .rating {
        font-size: 10px;
    }
}


    </script>
</div>

@endsection
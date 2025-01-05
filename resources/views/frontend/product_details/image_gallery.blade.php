<!-- Lightbox2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css" rel="stylesheet">

<!-- Lightbox2 JS -->
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>

<div class="sticky-top z-3 row gutters-10">
    @php
        $photos = [];
    @endphp
    @if ($detailedProduct->photos != null)
        @php
            $photos = explode(',', $detailedProduct->photos);
        @endphp
    @endif
    <!-- Gallery Images -->
    <div class="col-12">
        <div id="product-gallery" class="aiz-carousel product-gallery arrow-inactive-transparent arrow-lg-none"
            data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true' data-arrows='true'>
    
            @if ($detailedProduct->digital == 0)
                @foreach ($detailedProduct->stocks as $key => $stock)
                    @if ($stock->image != null)
                        <div class="carousel-box img-zoom rounded-0">
                            <a href="{{ uploaded_asset($stock->image) }}" data-lightbox="product-gallery">
                                <img class="img-fluid h-auto lazyload mx-auto"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($stock->image) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif
    
            @foreach ($photos as $key => $photo)
                <div class="carousel-box img-zoom rounded-0">
                    <a href="{{ uploaded_asset($photo) }}" data-lightbox="product-gallery">
                        <img class="img-fluid h-auto lazyload mx-auto"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photo) }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>
            @endforeach
    
        </div>
    </div>
    
    
    <!-- Thumbnail Images -->
    <div class="col-12 mt-3 d-none d-lg-block">
        <div class="aiz-carousel half-outside-arrow product-gallery-thumb" data-items='7' data-nav-for='.product-gallery'
            data-focus-select='true' data-arrows='true' data-vertical='false' data-auto-height='true'>

            @if ($detailedProduct->digital == 0)
                @foreach ($detailedProduct->stocks as $key => $stock)
                    @if ($stock->image != null)
                        <div class="carousel-box c-pointer rounded-0" data-variation="{{ $stock->variant }}">
                            <img class="lazyload mw-100 size-60px mx-auto border p-1"
                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                data-src="{{ uploaded_asset($stock->image) }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </div>
                    @endif
                @endforeach
            @endif

            @foreach ($photos as $key => $photo)
                <div class="carousel-box c-pointer rounded-0">
                    <img class="lazyload mw-100 size-60px mx-auto border p-1"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            @endforeach

        </div>
    </div>


</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productGallery = document.getElementById('product-gallery');

        function applyMobileFeature() {
            if (window.innerWidth <= 768) { // إذا كان العرض 768px أو أقل (نسخة الهاتف)
                // تفعيل Lightbox فقط في نسخة الهاتف
                document.querySelectorAll('#product-gallery a').forEach(link => {
                    link.setAttribute('data-lightbox', 'product-gallery');
                });
            } else {
                // إزالة Lightbox في نسخة اللابتوب وإبقاء الميزة السابقة
                document.querySelectorAll('#product-gallery a').forEach(link => {
                    link.removeAttribute('data-lightbox');
                });
            }
        }

        // تطبيق الميزة عند تحميل الصفحة
        applyMobileFeature();

        // تطبيق الميزة عند تغيير حجم الشاشة
        window.addEventListener('resize', applyMobileFeature);
    });
</script>


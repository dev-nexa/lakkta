@extends('frontend.layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-700 fs-20 fs-md-24 text-dark">
                        {{ translate('All Categories') }}
                    </h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item has-transition opacity-60 hov-opacity-100">
                            <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            "{{ translate('All Categories') }}"
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- All Categories -->
    <section class="mb-5 pb-3">
        <div class="container">
            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-3 g-3">
                @foreach ($categories as $key => $category)
                    <div class="col">
                        <div class="bg-white rounded-0 border h-100 p-2">
                            <!-- Category Name -->
                            <a href="{{ route('products.category', $category->slug) }}"
                                class="text-dark text-center d-block">
                                <div class="size-60px overflow-hidden p-1 border mx-auto mb-2">
                                    <img src="{{ uploaded_asset($category->banner) }}" alt=""
                                        class="img-fit h-100 w-100">
                                </div>
                                <div class="text-reset fs-14 fw-700 hov-text-primary">
                                    {{ $category->getTranslation('name') }}
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .size-60px {
            width: 60px;
            height: 60px;
        }

        .img-fit {
            object-fit: cover;
        }

        .has-transition {
            transition: max-height 0.3s ease;
        }

        .mh-100 {
            max-height: 100px;
            overflow: hidden;
        }
    </style>
@endsection

@section('script')
    <script>
        $('.show-hide-cetegoty').on('click', function() {
            var el = $(this).siblings('ul');
            if (el.hasClass('less')) {
                el.removeClass('less');
                $(this).html('{{ translate('Less') }} <i class="las la-angle-up"></i>');
            } else {
                el.addClass('less');
                $(this).html('{{ translate('More') }} <i class="las la-angle-down"></i>');
            }
        });
    </script>
@endsection

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
            @foreach ($categories as $key => $category)
                <div class="category-box mb-4 bg-white rounded shadow-sm border">
                    <!-- Header Section -->
                    <div class="category-header d-flex justify-content-between align-items-center p-4" data-toggle="collapse"
                         data-target="#category-children-{{ $key }}" aria-expanded="false"
                         aria-controls="category-children-{{ $key }}">
                        <div class="d-flex align-items-center">
                            <!-- Main Category Image -->
                            <a href="{{ route('products.category', $category->slug) }}" class="text-dark category-name-link">
                                <div class="category-img-wrapper size-60px overflow-hidden rounded-circle p-1 border mr-3">
                                    <img src="{{ uploaded_asset($category->banner) }}" alt="" class="img-fit h-100 w-100">
                                </div>
                            </a>
                            <!-- Main Category Name -->
                            <a href="{{ route('products.category', $category->slug) }}" class="text-reset fw-bold fs-20 text-decoration-none category-name-link">
                                {{ $category->getTranslation('name') }}
                            </a>
                        </div>
                        <!-- Toggle Icon -->
                        @if ($category->childrenCategories->count() > 0)
                            <div class="category-toggle d-flex align-items-center">
                                <span class="toggle-icon fs-20 cursor-pointer">
                                    <i class="las la-angle-down"></i>
                                </span>
                            </div>
                        @endif
                    </div>
    
                    <!-- Dropdown Section -->
                    @if ($category->childrenCategories->count() > 0)
                        <div id="category-children-{{ $key }}">
                            <div class="category-children px-4 py-3">
                                <div class="row justify-content-center">
                                    @foreach ($category->childrenCategories as $child_category)
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3 text-center">
                                            <div class="child-category-box p-3 border rounded bg-light">
                                                <!-- Sub-category Image -->
                                                <a href="{{ route('products.category', $category->slug) }}" class="text-dark category-name-link">
                                                    <div class="category-img-wrapper size-60px overflow-hidden rounded-circle p-1 border mx-auto mb-2">
                                                        <img src="{{ uploaded_asset($child_category->banner) }}" alt="" class="img-fit h-100 w-100">
                                                    </div>
                                                </a>
                                                <!-- Sub-category Name -->
                                                <a href="{{ route('products.category', $child_category->slug) }}"
                                                    class="text-reset fw-700 fs-16 text-decoration-none hov-text-primary">
                                                    {{ $child_category->getTranslation('name') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    
    <script>
        $(document).ready(function () {
            $('.category-name-link').on('click', function (event) {
                event.stopPropagation();
            });
        
            $('.category-header').on('click', function (e) {
                const target = $(e.target);
            
                if (!target.is('a') && !target.closest('.category-img-wrapper').length) {
                    $(this).attr('data-target') && $($(this).attr('data-target')).collapse('toggle');
                }
            });
        });
    </script>
    
    <style>
        .category-box {
            transition: all 0.3s ease;
        }

        .category-box:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .category-img-wrapper {
            width: 80px;
            height: 80px;
        }

        .category-img-wrapper img {
            object-fit: cover;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .category-img-wrapper:hover img {
            transform: scale(1.1);
        }

        .category-header {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .category-header:hover {
            background-color: #f8f9fa;
        }

        .child-category-box {
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .child-category-box:hover {
            background-color: #e9ecef;
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .toggle-icon {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        [aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 576px) {
            .child-category-box {
                margin-bottom: 1rem;
            }
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

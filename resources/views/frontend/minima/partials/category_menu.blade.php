{{-- TODO <div class="aiz-category-menu bg-white rounded-0 border-top" id="category-sidebar" style="width:270px;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        @foreach (get_level_zero_categories()->take(12) as $key => $category)
            @php
                $category_name = $category->getTranslation('name');
            @endphp
            <li class="category-nav-element border border-top-0" data-id="{{ $category->id }}">
                <a href="{{ route('products.category', $category->slug) }}"
                    class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                    <img class="cat-image lazyload mr-2 opacity-60" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($category->catIcon->file_name) ? my_asset($category->catIcon->file_name) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $category_name }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    <span class="cat-name has-transition">{{ translate($category_name) }}</span>
                </a>
                
                <div class="sub-cat-menu more c-scrollbar-light border p-4 shadow-none">
                    <div class="c-preloader text-center absolute-center">
                        <i class="las la-spinner la-spin la-3x opacity-70"></i>
                    </div>
                </div>

            </li>
        @endforeach
    </ul>
</div> --}}
<div class="aiz-category-menu bg-white rounded-0 border-top" id="category-sidebar" style="width:270px;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        @php
            $parentCategoryId = 30; // رقم الفئة الرئيسية المطلوبة
            $parentCategory = \App\Models\Category::find($parentCategoryId);
            $childCategories = $parentCategory ? $parentCategory->childrenCategories : collect();
        @endphp

        @if ($parentCategory)
            <li class="category-nav-element border border-top-0" data-id="{{ $parentCategory->id }}">
                <a href="{{ route('products.category', $parentCategory->slug) }}"
                    class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                    <img class="cat-image lazyload mr-2 opacity-60" 
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($parentCategory->catIcon->file_name) ? my_asset($parentCategory->catIcon->file_name) : static_asset('assets/img/placeholder.jpg') }}" width="16" 
                        alt="{{ $parentCategory->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    <span class="cat-name has-transition">{{ $parentCategory->getTranslation('name') }}</span>
                </a>
            </li>
        @endif

        @foreach ($childCategories as $childCategory)
            @php
                $childCategoryName = $childCategory->getTranslation('name');
            @endphp
            <li class="category-nav-element border border-top-0" data-id="{{ $childCategory->id }}">
                <a href="{{ route('products.category', $childCategory->slug) }}"
                    class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                    <img class="cat-image lazyload mr-2 opacity-60" 
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($childCategory->catIcon->file_name) ? my_asset($childCategory->catIcon->file_name) : static_asset('assets/img/placeholder.jpg') }}" width="16" 
                        alt="{{ $childCategoryName }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    <span class="cat-name has-transition">{{ $childCategoryName }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>


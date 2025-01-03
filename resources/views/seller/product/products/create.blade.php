<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@extends('seller.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('panel_content')
    <div class="page-content mx-0">
        <div class="aiz-titlebar mt-2 mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3">{{ translate('Add Your Product') }}</h1>
                    <p class="text-muted mt-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ translate('The more detailed and clear your cars information, the higher the chances of attracting interested buyers') }}
                    </p>
                </div>
                <div class="col text-right">
                    <a class="btn btn-xs btn-soft-primary" href="javascript:void(0);" onclick="clearTempdata()">
                        {{ translate('Clear Tempdata') }}
                    </a>
                </div>
            </div>
        </div>
        

        <!-- Error Meassages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Data type -->
        <input type="hidden" id="data_type" value="physical">

        <form class="" action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8">
                    @csrf
                    <input type="hidden" name="added_by" value="seller">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Product Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-car-side mr-2"></i> <!-- أيقونة اسم المنتج -->
                                    {{ translate('Product Name') }} <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ translate('Product Name') }}" onchange="update_sku()" required>
                                </div>
                            </div>
                        
                            <!-- Category -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-th-list mr-2"></i> <!-- أيقونة الفئة -->
                                    {{ translate('Category') }}
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id" data-live-search="true" required>
                                        <option value="">{{ translate('Select Category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" class="category-option" data-parent-id="{{ $category->parent_id }}">
                                                {{ $category->getTranslation('name') }}
                                            </option>
                                            
                                            @foreach ($category->childrenCategories as $childCategory)
                                                <option value="{{ $childCategory->id }}" class="subcategory-option" data-parent-id="{{ $category->id }}">
                                                    &nbsp;&nbsp;&nbsp;-- {{ $childCategory->getTranslation('name') }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                            <!-- Brand -->
                            <div class="form-group row" id="brand">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-industry mr-2"></i> <!-- أيقونة العلامة التجارية -->
                                    {{ translate('Brand') }}
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="brand_id" id="brand-select" data-live-search="true">
                                        <option value="">{{ translate('Select Brand') }}</option>
                                    </select>
                                </div>
                            </div>
                        
                            <!-- Model -->
                            <div class="form-group row" id="model">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-car-alt mr-2"></i> <!-- أيقونة النموذج -->
                                    {{ translate('Model') }}
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="model_id" id="model-select" data-live-search="true">
                                        <option value="">{{ translate('Select Model') }}</option>
                                    </select>
                                </div>
                            </div>
                        
                            <input type="hidden" name="category_id" id="category_id_hidden">
                            <input type="hidden" name="category_ids[]" id="category_ids_hidden">
                            
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ translate('Year of manufacture') }} <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="1900" value="1900" step="1"
                                        placeholder="{{ translate('Year of manufacture') }}" name="manufacture" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-book mr-2"></i>
                                    {{ translate('Registration year') }} <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="1900" value="1900" step="1"
                                        placeholder="{{ translate('Registration year') }}" name="registration" class="form-control"
                                        required>
                                </div>
                            </div>

                            @if (addon_is_activated('pos_system'))
                                <!-- Barcode -->
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        <i class="fas fa-barcode mr-2"></i> <!-- أيقونة الباركود -->
                                        {{ translate('Barcode') }}
                                    </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="barcode"
                                            placeholder="{{ translate('Barcode') }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                <i class="fas fa-images mr-2"></i> <!-- أيقونة الصور -->
                                {{ translate('Product Images') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ translate('Upload multiple clear and high-quality images to showcase your car effectively.') }}
                            </p>
                            
                            <!-- Gallery Images -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">
                                    <i class="fas fa-image mr-2"></i> <!-- أيقونة معرض الصور -->
                                    {{ translate('Gallery Images') }}
                                </label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}
                                            </div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="photos" class="selected-files">
                                        <input type="hidden" name="meta_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm"></div>
                                    <small class="text-muted">
                                        {{ translate('Recommended dimensions: 900px X 900px.') }}
                                    </small>
                                </div>
                            </div>
                    
                            <!-- Thumbnail Image -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">
                                    <i class="fas fa-file-image mr-2"></i> <!-- أيقونة الصورة المصغرة -->
                                    {{ translate('Thumbnail Image') }}
                                </label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}
                                            </div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="thumbnail_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm"></div>
                                    <small class="text-muted">
                                        {{ translate('Recommended dimensions: 195px X 195px. Leave some blank space around the object.') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                <i class="fas fa-video mr-2"></i> <!-- أيقونة الفيديو -->
                                {{ translate('Product Videos') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Video Provider -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-play-circle mr-2"></i> <!-- أيقونة مقدم الفيديو -->
                                    {{ translate('Video Provider') }}
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
                                        <option value="youtube">
                                            <i class="fab fa-youtube mr-2"></i> <!-- أيقونة YouTube -->
                                            {{ translate('Youtube') }}
                                        </option>
                                        <option value="dailymotion">
                                            <i class="fab fa-dailymotion mr-2"></i> <!-- أيقونة Dailymotion -->
                                            {{ translate('Dailymotion') }}
                                        </option>
                                        <option value="vimeo">
                                            <i class="fab fa-vimeo mr-2"></i> <!-- أيقونة Vimeo -->
                                            {{ translate('Vimeo') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Video Link -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-link mr-2"></i> <!-- أيقونة رابط الفيديو -->
                                    {{ translate('Video Link') }}
                                </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="video_link"
                                        placeholder="{{ translate('Video Link') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                <i class="fas fa-layer-group mr-2"></i> <!-- أيقونة التباين -->
                                {{ translate('Product Variation') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Colors -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">
                                    <i class="fas fa-palette mr-2"></i> <!-- أيقونة الألوان -->
                                    {{ translate('Colors') }}
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" data-live-search="true" name="colors[]"
                                        data-selected-text-format="count" id="colors" multiple disabled>
                                        @foreach (\App\Models\Color::orderBy('name', 'asc')->get() as $key => $color)
                                            <option value="{{ $color->code }}"
                                                data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>">
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input value="1" type="checkbox" name="colors_active">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                    
                            <!-- Attributes -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">
                                    <i class="fas fa-cogs mr-2"></i> <!-- أيقونة الخصائص -->
                                    {{ translate('Attributes') }}
                                </label>
                                <div class="col-md-8">
                                    <select name="choice_attributes[]" id="choice_attributes"
                                        class="form-control aiz-selectpicker" data-live-search="true"
                                        data-selected-text-format="count" multiple
                                        data-placeholder="{{ translate('Choose Attributes') }}">
                                        @foreach (\App\Models\Attribute::all() as $key => $attribute)
                                            <option value="{{ $attribute->id }}">{{ $attribute->getTranslation('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Help Text -->
                            <div>
                                <p>
                                    <i class="fas fa-info-circle mr-2"></i> <!-- أيقونة معلومات -->
                                    {{ translate('Choose the attributes of this product and then input values of each attribute') }}
                                </p>
                                <br>
                            </div>
                    
                            <!-- Dynamic Attributes Section -->
                            <div class="customer_choice_options" id="customer_choice_options">
                                <!-- خيارات الخصائص الديناميكية ستظهر هنا -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                <i class="fas fa-money-bill-alt mr-2"></i> <!-- أيقونة السعر -->
                                {{ translate('Product price') }}
                            </h5>
                            <p class="text-muted mt-1">
                                {{ translate('Set a competitive price to attract buyers and ensure a quick sale.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            <!-- Unit Price -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-dollar-sign mr-2"></i> <!-- أيقونة السعر -->
                                    {{ translate('Unit price') }} <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="0.01"
                                        placeholder="{{ translate('Unit price') }}" name="unit_price" class="form-control"
                                        required>
                                </div>
                            </div>
                    
                            <!-- Discount Date Range -->
                            {{-- TODO --}}
                            {{-- <div class="form-group row">
                                <label class="col-md-3 control-label" for="start_date">
                                    <i class="fas fa-calendar-alt mr-2"></i> <!-- أيقونة التاريخ -->
                                    {{ translate('Discount Date Range') }}
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control aiz-date-range" name="date_range"
                                        placeholder="{{ translate('Select Date') }}" data-time-picker="true"
                                        data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                                </div>
                            </div> --}}
                    
                            <!-- Discount -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-percent mr-2"></i> <!-- أيقونة الخصم -->
                                    {{ translate('Discount') }} <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="0.01"
                                        placeholder="{{ translate('Discount') }}" name="discount" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control aiz-selectpicker" name="discount_type">
                                        <option value="amount">{{ translate('Flat') }}</option>
                                        <option value="percent">{{ translate('Percent') }}</option>
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Quantity -->
                            {{-- TODO --}}
                            {{-- <div id="show-hide-div">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        <i class="fas fa-boxes mr-2"></i> <!-- أيقونة الكمية -->
                                        {{ translate('Quantity') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="number" lang="en" min="0" value="0" step="1"
                                            placeholder="{{ translate('Quantity') }}" name="current_stock"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div> --}}
                        <div id="show-hide-div" style="display: none;">
                            <input type="hidden" name="current_stock" value="1"> <!-- القيمة الافتراضية -->
                        </div>
                                
                    
                            <!-- External Link -->
                            {{-- TODO
                            @if(get_setting('product_external_link_for_seller') == 1)
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        <i class="fas fa-external-link-alt mr-2"></i> <!-- أيقونة الرابط الخارجي -->
                                        {{ translate('External link') }}
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="{{ translate('External link') }}"
                                            name="external_link" class="form-control">
                                        <small
                                            class="text-muted">{{ translate('Leave it blank if you do not use external site link') }}</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        <i class="fas fa-link mr-2"></i> <!-- أيقونة نص الزر -->
                                        {{ translate('External link button text') }}
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="{{ translate('External link button text') }}"
                                            name="external_link_btn" class="form-control">
                                        <small
                                            class="text-muted">{{ translate('Leave it blank if you do not use external site link') }}</small>
                                    </div>
                                </div>
                            @endif
                     --}}
                            <!-- SKU Combination -->
                            <div class="sku_combination" id="sku_combination"></div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                <i class="fas fa-align-left mr-2"></i> <!-- أيقونة الوصف -->
                                {{ translate('Product Description') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Description -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    <i class="fas fa-pen-nib mr-2"></i> <!-- أيقونة النص -->
                                    {{ translate('Description') }}
                                </label>
                                <div class="col-md-8">
                                    <textarea class="aiz-text-editor" name="description" placeholder="{{ translate('Write product description...') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('PDF Specification') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('PDF Specification') }}</label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="document">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="pdf" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('SEO Meta Tags') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Meta Title') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="meta_title"
                                        placeholder="{{ translate('Meta Title') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                                <div class="col-md-8">
                                    <textarea name="meta_description" rows="8" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Meta Image') }}</label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="meta_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <input type="hidden" name="meta_title">
                    <input type="hidden" name="meta_description">

                    <script>
                        document.getElementById('product_name').addEventListener('input', function() {
                            document.getElementById('meta_title').value = this.value;
                        });
                    
                        document.getElementById('product_description').addEventListener('input', function() {
                            document.getElementById('meta_description').value = this.value;
                        });
                    </script>

                    {{-- Refund --}}
                    @if (addon_is_activated('refund_request'))
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Refund') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Refundable')}}?</label>
                                    <div class="col-md-10">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="refundable" checked value="1" onchange="isRefundable()">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="w-100 refund-block d-none">
                                    <div class="form-group row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <input type="hidden" name="refund_note_id" id="refund_note_id">
                                            
                                            <h5 class="fs-14 fw-600 mb-3 mt-4 pb-3" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Refund Note')}}</h5>
                                            <div id="refund_note" class="">

                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-block border border-dashed hov-bg-soft-secondary mt-2 fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                                onclick="noteModal('refund')">
                                                <i class="las la-plus"></i>
                                                <span class="ml-2">{{ translate('Select Refund Note') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    

                    {{-- Warranty --}}
                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Warranty') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2 col-from-label">{{translate('Warranty')}}</label>
                                <div class="col-md-10">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="has_warranty" onchange="warrantySelection()">
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="w-100 warranty_selection_div d-none">
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <select class="form-control aiz-selectpicker" 
                                            name="warranty_id" 
                                            id="warranty_id" 
                                            data-live-search="true">
                                            <option value="">{{ translate('Select Warranty') }}</option>
                                            @foreach (\App\Models\Warranty::all() as $warranty)
                                                <option value="{{ $warranty->id }}" @selected(old('warranty_id') == $warranty->id)>{{ $warranty->getTranslation('text') }}</option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="warranty_note_id" id="warranty_note_id">
                                        
                                        <h5 class="fs-14 fw-600 mb-3 mt-4 pb-3" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Warranty Note')}}</h5>
                                        <div id="warranty_note" class="">

                                        </div>
                                        <button
                                            type="button"
                                            class="btn btn-block border border-dashed hov-bg-soft-secondary mt-2 fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                            onclick="noteModal('warranty')">
                                            <i class="las la-plus"></i>
                                            <span class="ml-2">{{ translate('Select Warranty Note') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- Frequently Bought Products --}}
                    <div class="card">
                            {{-- <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Frequently Bought') }}</h5>
                            </div> --}}
                        <div class="w-100">
                            {{-- <div class="d-flex my-3">
                                <div class="align-items-center d-flex mar-btm ml-4 mr-5 radio">
                                    <input id="fq_bought_select_products" type="radio" name="frequently_bought_selection_type" value="product" onchange="fq_bought_product_selection_type()" checked >
                                    <label for="fq_bought_select_products" class="fs-14 fw-500 mb-0 ml-2">{{translate('Select Product')}}</label>
                                </div>
                                <div class="radio mar-btm mr-3 d-flex align-items-center">
                                    <input id="fq_bought_select_category" type="radio" name="frequently_bought_selection_type" value="category" onchange="fq_bought_product_selection_type()">
                                    <label for="fq_bought_select_category" class="fs-14 fw-500 mb-0 ml-2">{{translate('Select Category')}}</label>
                                </div>
                            </div> --}}

                            <div class="px-3 px-md-4">
                               {{-- TODO --}}
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="fq_bought_select_product_div">

                                            <div id="selected-fq-bought-products">

                                            </div>

                                            <button
                                                type="button"
                                                class="btn btn-block border border-dashed hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                                onclick="showFqBoughtProductModal()">
                                                <i class="las la-plus"></i>
                                                <span class="ml-2">{{ translate('Add More') }}</span>
                                            </button>
                                        </div>

                                        <div class="fq_bought_select_category_div d-none">
                                            <div class="form-group row">
                                                <label class="col-md-2 col-from-label">{{translate('Category')}}</label>
                                                <div class="col-md-10">
                                                    <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Select a Category')}}" name="fq_bought_product_category_id" data-live-search="true" required>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                                            @foreach ($category->childrenCategories as $childCategory)
                                                                @include('categories.child_category', ['child_category' => $childCategory])
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product Category') }}</h5>
                            <h6 class="float-right fs-13 mb-0">
                                {{ translate('Select Main') }}
                                <span class="position-relative main-category-info-icon">
                                    <i class="las la-question-circle fs-18 text-info"></i>
                                    <span class="main-category-info bg-soft-info p-2 position-absolute d-none border">
                                        {{ translate('This will be used for commission based calculations and homepage category wise product Show.') }}
                                    </span>
                                </span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="h-300px overflow-auto c-scrollbar-light">
                                <ul class="hummingbird-treeview-converter list-unstyled" data-checkbox-name="category_ids[]" data-radio-name="category_id" id="category-tree">
                                    @foreach ($categories as $category)
                                        <li id="category-{{ $category->id }}" data-id="{{ $category->id }}">{{ $category->getTranslation('name') }}
                                            @if ($category->childrenCategories->isNotEmpty())
                                                <ul>
                                                    @foreach ($category->childrenCategories as $childCategory)
                                                        @include('backend.product.products.child_category', ['child_category' => $childCategory])
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                {{ translate('Shipping Configuration') }}
                            </h5>
                        </div>

                        <div class="card-body">
                            @if (get_setting('shipping_type') == 'product_wise_shipping')
                                <div class="form-group row">
                                    <label class="col-md-6 col-from-label">{{ translate('Free Shipping') }}</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="radio" name="shipping_type" value="free" checked>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-6 col-from-label">{{ translate('Flat Rate') }}</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="radio" name="shipping_type" value="flat_rate">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flat_rate_shipping_div" style="display: none">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">{{ translate('Shipping cost') }}</label>
                                        <div class="col-md-6">
                                            <input type="number" lang="en" min="0" value="0"
                                                step="0.01" placeholder="{{ translate('Shipping cost') }}"
                                                name="flat_shipping_cost" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-6 col-from-label">{{translate('Is Product Quantity Mulitiply')}}</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="is_quantity_multiplied" value="1">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            @else
                                <p>
                                    {{ translate('Shipping configuration is maintained by Admin.') }}
                                </p>
                            @endif
                        </div>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Low Stock Quantity Warning') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Quantity') }}
                                </label>
                                <input type="number" name="low_stock_quantity" value="1" min="0"
                                    step="1" class="form-control">
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                {{ translate('Stock Visibility State') }}
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Show Stock Quantity') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="quantity" checked>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Show Stock With Text Only') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="text">
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Hide Stock') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="hide">
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Cash On Delivery') }}</h5>
                        </div>
                        <div class="card-body">
                            @if (get_setting('cash_payment') == '1')
                                <div class="form-group row">
                                    <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="cash_on_delivery" value="1" checked="">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            @else
                                <p>
                                    {{ translate('Cash On Delivery activation is maintained by Admin.') }}
                                </p>
                            @endif
                        </div>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Estimate Shipping Time') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Shipping Days') }}
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="est_shipping_days" min="1"
                                        step="1" placeholder="{{ translate('Shipping Days') }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">{{ translate('Days') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('VAT & Tax') }}</h5>
                        </div>
                        <div class="card-body">
                            @foreach (\App\Models\Tax::where('tax_status', 1)->get() as $tax)
                                <label for="name">
                                    {{ $tax->name }}
                                    <input type="hidden" value="{{ $tax->id }}" name="tax_id[]">
                                </label>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="number" lang="en" min="0" value="0" step="0.01"
                                            placeholder="{{ translate('Tax') }}" name="tax[]" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select class="form-control aiz-selectpicker" name="tax_type[]">
                                            <option value="amount">{{ translate('Flat') }}</option>
                                            <option value="percent">{{ translate('Percent') }}</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
                <div class="col-12">
                    <div class="mar-all text-right mb-2">
                        <button type="submit" name="button" value="publish"
                            class="btn btn-primary">{{ translate('Upload Product') }}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('modal')
	<!-- Frequently Bought Product Select Modal -->
    @include('modals.product_select_modal')

    {{-- Note Modal --}}
    @include('modals.note_modal')
@endsection

@section('script')
<!-- Treeview js -->
<script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('#category_id').on('change', function () {
        const categoryId = $(this).val(); 

            if (categoryId) {
                $('#category_id_hidden').val(categoryId);

                $('#category_ids_hidden').val(categoryId);
            } else {
                $('#category_id_hidden').val('');
                $('#category_ids_hidden').val('');
            }
        });
    });

    $(document).ready(function () {
        $('#category_id').on('change', function () {
            const categoryId = $(this).val();
                                    
            if (categoryId) {
                $.ajax({
                    url: '{{ route('get-brands-by-category') }}',
                    method: 'GET',
                    data: { category_id: categoryId },
                    success: function (data) {
                        if (data.length > 0) {
                            $('#brand-select').empty();
                            $('#brand-select').append('<option value="">{{ translate('Select Brand') }}</option>');
                            $('#model-select').empty();
                            $('#model-select').append('<option value="">{{ translate('Select Model') }}</option>');
                        
                            data.forEach(function (brand) {
                                $('#brand-select').append('<option value="' + brand.id + '">' + brand.name + '</option>');
                            });
                        
                            $('#brand-select').selectpicker('refresh');
                        } else {
                            $('#brand-select').empty().append('<option value="">{{ translate('No Brands Available') }}</option>');
                            $('#brand-select').selectpicker('refresh');
                            $('#model-select').empty().append('<option value="">{{ translate('No Models Available') }}</option>');
                            $('#model-select').selectpicker('refresh');
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            } else {
                $('#brand-select').empty().append('<option value="">{{ translate('Select Brand') }}</option>');
                $('#brand-select').selectpicker('refresh');
            }

            const brandId = $(this).val();
        
            if (brandId) {
                $.ajax({
                    url: '{{ route('get-models-by-brand') }}',
                    method: 'GET',
                    data: { brand_id: brandId },
                    success: function (data) {
                        if (data.length > 0) {
                            $('#model-select').empty();
                            $('#model-select').append('<option value="">{{ translate('Select Model') }}</option>');
                        
                            // data.forEach(function (model) {
                            //     $('#model-select').append('<option value="' + model.id + '">' + model.name + '</option>');
                            // });
                        
                            $('#model-select').selectpicker('refresh');
                        } else {
                            $('#model-select').empty().append('<option value="">{{ translate('No Models Available') }}</option>');
                            $('#model-select').selectpicker('refresh');
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            } else {
                $('#model-select').empty().append('<option value="">{{ translate('Select Model') }}</option>');
                $('#model-select').selectpicker('refresh');
            }
        });
                                
        $('#brand-select').on('change', function () {
            const brandId = $(this).val();
        
            if (brandId) {
                $.ajax({
                    url: '{{ route('get-models-by-brand') }}',
                    method: 'GET',
                    data: { brand_id: brandId },
                    success: function (data) {
                        if (data.length > 0) {
                            $('#model-select').empty();
                            $('#model-select').append('<option value="">{{ translate('Select Model') }}</option>');
                        
                            data.forEach(function (model) {
                                $('#model-select').append('<option value="' + model.id + '">' + model.name + '</option>');
                            });
                        
                            $('#model-select').selectpicker('refresh');
                        } else {
                            $('#model-select').empty().append('<option value="">{{ translate('No Models Available') }}</option>');
                            $('#model-select').selectpicker('refresh');
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            } else {
                $('#model-select').empty().append('<option value="">{{ translate('Select Model') }}</option>');
                $('#model-select').selectpicker('refresh');
            }
        });
    });

    $(document).ready(function() {
        $("#treeview").hummingbird();

        $('#treeview input:checkbox').on("click", function (){
            let $this = $(this);
            if ($this.prop('checked') && ($('#treeview input:radio:checked').length == 0)) {
                let val = $this.val();
                $('#treeview input:radio[value='+val+']').prop('checked',true);
            }
        });
    });

    $("[name=shipping_type]").on("change", function() {
        $(".product_wise_shipping_div").hide();
        $(".flat_rate_shipping_div").hide();
        if ($(this).val() == 'product_wise') {
            $(".product_wise_shipping_div").show();
        }
        if ($(this).val() == 'flat_rate') {
            $(".flat_rate_shipping_div").show();
        }

    });

    function add_more_customer_choice_option(i, name) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '{{ route('seller.products.add-more-choice-option') }}',
            data: {
                attribute_id: i
            },
            success: function(data) {
                var obj = JSON.parse(data);
                $('#customer_choice_options').append('\
                    <div class="form-group row">\
                        <div class="col-md-3">\
                            <input type="hidden" name="choice_no[]" value="' + i + '">\
                            <input type="text" class="form-control" name="choice[]" value="' + name +
                    '" placeholder="{{ translate('Choice Title') }}" readonly>\
                        </div>\
                        <div class="col-md-8">\
                            <select class="form-control aiz-selectpicker attribute_choice" data-live-search="true" name="choice_options_' + i + '[]" multiple>\
                                ' + obj + '\
                            </select>\
                        </div>\
                    </div>');
                AIZ.plugins.bootstrapSelect('refresh');
            }
        });


    }

    $('input[name="colors_active"]').on('change', function() {
        if (!$('input[name="colors_active"]').is(':checked')) {
            $('#colors').prop('disabled', true);
            AIZ.plugins.bootstrapSelect('refresh');
        } else {
            $('#colors').prop('disabled', false);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        update_sku();
    });

    $(document).on("change", ".attribute_choice", function() {
        update_sku();
    });

    $('#colors').on('change', function() {
            update_sku();
        });

    $('input[name="unit_price"]').on('keyup', function() {
        update_sku();
    });

    // $('input[name="name"]').on('keyup', function() {
    //     update_sku();
    // });

    function delete_row(em) {
        $(em).closest('.form-group row').remove();
        update_sku();
    }

    function delete_variant(em) {
        $(em).closest('.variant').remove();
    }

    function update_sku() {
        $.ajax({
            type: "POST",
            url: '{{ route('seller.products.sku_combination') }}',
            data: $('#choice_form').serialize(),
            success: function(data) {
                $('#sku_combination').html(data);
                AIZ.uploader.previewGenerate();
                AIZ.plugins.sectionFooTable('#sku_combination');
                if (data.trim().length > 1) {
                    $('#show-hide-div').hide();
                } else {
                    $('#show-hide-div').show();
                }
            }
        });
    }

    $('#choice_attributes').on('change', function() {
        $('#customer_choice_options').html(null);
        $.each($("#choice_attributes option:selected"), function() {
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
        update_sku();
    });

    function fq_bought_product_selection_type(){
        var productSelectionType = $("input[name='frequently_bought_selection_type']:checked").val();
        if(productSelectionType == 'product'){
            $('.fq_bought_select_product_div').removeClass('d-none');
            $('.fq_bought_select_category_div').addClass('d-none');
        }
        else if(productSelectionType == 'category'){
            $('.fq_bought_select_category_div').removeClass('d-none');
            $('.fq_bought_select_product_div').addClass('d-none');
        }
    }

    function showFqBoughtProductModal() {
        $('#fq-bought-product-select-modal').modal('show', {backdrop: 'static'});
    }

    function filterFqBoughtProduct() {
        var searchKey = $('input[name=search_keyword]').val();
        var fqBroughCategory = $('select[name=fq_brough_category]').val();
        $.post('{{ route('seller.product.search') }}', { _token: AIZ.data.csrf, product_id: null, search_key:searchKey, category:fqBroughCategory, product_type:"physical" }, function(data){
            $('#product-list').html(data);
            AIZ.plugins.sectionFooTable('#product-list');
        });
    }

    function addFqBoughtProduct() {
        var selectedProducts = [];
        $("input:checkbox[name=fq_bought_product_id]:checked").each(function() {
            selectedProducts.push($(this).val());
        });

        var fqBoughtProductIds = [];
        $("input[name='fq_bought_product_ids[]']").each(function() {
            fqBoughtProductIds.push($(this).val());
        });

        var productIds = selectedProducts.concat(fqBoughtProductIds.filter((item) => selectedProducts.indexOf(item) < 0))

        $.post('{{ route('seller.get-selected-products') }}', { _token: AIZ.data.csrf, product_ids:productIds}, function(data){
            $('#fq-bought-product-select-modal').modal('hide');
            $('#selected-fq-bought-products').html(data);
            AIZ.plugins.sectionFooTable('#selected-fq-bought-products');
        });
    }

    // Warranty
    function warrantySelection(){
        if($('input[name="has_warranty"]').is(':checked')) {
            $('.warranty_selection_div').removeClass('d-none');
            $('#warranty_id').attr('required', true);
        }
        else {
            $('.warranty_selection_div').addClass('d-none');
            $('#warranty_id').removeAttr('required');
        }
    }

    // Refundable
    function isRefundable(){
        if($('input[name="refundable"]').is(':checked')) {
            $('.refund-block').removeClass('d-none');
        }
        else {
            $('.refund-block').addClass('d-none');
        }
    }
    
    function noteModal(noteType){
        $.post('{{ route('get_notes') }}',{_token:'{{ @csrf_token() }}', note_type: noteType}, function(data){
            $('#note_modal #note_modal_content').html(data);
            $('#note_modal').modal('show', {backdrop: 'static'});
        });
    }

    function addNote(noteId, noteType){
        var noteDescription = $('#note_description_'+ noteId).val();
        $('#'+noteType+'_note_id').val(noteId);
        $('#'+noteType+'_note').html(noteDescription);
        $('#'+noteType+'_note').addClass('border border-gray my-2 p-2');
        $('#note_modal').modal('hide');
    }


</script>

@include('partials.product.product_temp_data')
<script type="text/javascript">
    $(document).ready(function() {
        warrantySelection();
        isRefundable();
    });
</script>
@endsection

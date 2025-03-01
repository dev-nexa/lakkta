@extends('seller.layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">
                <i class="fas fa-edit mr-2"></i> <!-- أيقونة التعديل -->
                {{ translate('Update your product') }}
            </h1>
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

<form class="" action="{{route('seller.products.update', $product->id)}}" method="POST" enctype="multipart/form-data"
    id="choice_form">
    <div class="row gutters-5">
        <div class="col-lg-8">
            <input name="_method" type="hidden" value="POST">
            <input type="hidden" name="lang" value="{{ $lang }}">
            <input type="hidden" name="id" value="{{ $product->id }}">
            @csrf
            <input type="hidden" name="added_by" value="seller">
            <div class="card">
                <ul class="nav nav-tabs nav-fill language-bar">
                    @foreach (get_all_active_language() as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link text-reset @if ($language->code == $lang) active @endif py-3"
                            href="{{ route('seller.products.edit', ['id'=>$product->id, 'lang'=> $language->code] ) }}">
                            <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11"
                                class="mr-1">
                            <span>{{$language->name}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="card-body">
                    <!-- Product Name -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-car-side mr-2"></i>
                            {{translate('Product Name')}} 
                            <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i>
                        </label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{translate('Product Name')}}" value="{{$product->getTranslation('name',$lang)}}"
                                required>
                        </div>
                    </div>
                    
                    <!-- Category -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            <i class="fas fa-th-list mr-2"></i>
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
                            <i class="fas fa-industry mr-2"></i>
                            {{ translate('Brand') }}
                        </label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand-select" data-live-search="true">
                                <option value="">{{ translate('Select Brand') }}</option>
                            </select>
                        </div>
                    </div>
                
                    <!-- Model -->
                    {{-- <div class="form-group row" id="model">
                        <label class="col-md-3 col-from-label">
                            <i class="fas fa-car-alt mr-2"></i>
                            {{ translate('Model') }}
                        </label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="model_id" id="model-select" data-live-search="true">
                                <option value="">{{ translate('Select Model') }}</option>
                            </select>
                        </div>
                    </div> --}}
                
                    <input type="hidden" name="category_id" id="category_id_hidden">
                    <input type="hidden" name="category_ids[]" id="category_ids_hidden">

                    <!-- Status -->
                    <div class="form-group row" id="status">
                        <label class="col-md-3 col-from-label">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ translate('Status') }}
                        </label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="status" id="status-select" data-live-search="true" required>
                                <option value="">{{ translate('Select Status') }}</option>
                                <option value="new">{{ translate('New') }}</option>
                                <option value="used">{{ translate('Used') }}</option>
                                <option value="illegal">{{ translate('Illegal') }}</option>
                                <option value="snipped">{{ translate('Snipped') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Phone Number -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            <i class="fas fa-phone-alt mr-2"></i> 
                            {{ translate('Phone Number') }}
                        </label>
                        <div class="col-md-8">
                            <input type="tel" id="phone-input" class="form-control phone-input-custom" placeholder="{{ translate('Enter your phone number') }}" value="{{ $product->phone}}">
                            <input type="hidden" id="full-phone" name="phone_number" value="{{ $product->phone }}">
                        </div>
                    </div>

                    <style>
                        .phone-input-custom {
                            padding-left: 60px !important;
                            border-radius: 8px;
                            border: 1px solid #ddd;
                            height: 50px;
                            font-size: 18px;
                            transition: all 0.3s ease-in-out;
                        }
                    
                        .phone-input-custom:focus {
                            border-color: #007665;
                            box-shadow: 0 0 8px rgba(0, 118, 101, 0.3);
                        }
                    
                        .iti {
                            width: 100%;
                        }
                    
                        .iti__selected-flag {
                            background-color: #007665;
                            border-top-left-radius: 8px;
                            border-bottom-left-radius: 8px;
                            padding: 12px 20px;
                        }
                    
                        .iti__flag-container {
                            border-radius: 8px;
                        }
                    
                        .iti__dropdown-content {
                            max-height: 300px;
                            border-radius: 8px;
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                        }
                    
                        .iti__country-list {
                            border-radius: 8px;
                            background-color: #fff;
                            box-shadow: 0 4px 20px rgba(0, 118, 101, 0.2);
                            font-size: 16px;
                        }
                    
                        .iti__country {
                            padding: 15px;
                            transition: all 0.2s ease-in-out;
                        }
                    
                        .iti__country:hover {
                            background-color: #007665;
                            color: #fff;
                        }
                    
                        .iti__country-name {
                            font-weight: bold;
                        }
                    </style>
                    
                    <script>
                        var input = document.querySelector("#phone-input");
                        var hiddenInput = document.querySelector("#full-phone");
                    
                        var savedCountry = localStorage.getItem('phone_country') || "sy";
                    
                        var iti = intlTelInput(input, {
                            initialCountry: savedCountry,
                            preferredCountries: ["sy", "ae", "lb", "sa", "jo", "tr"],
                            separateDialCode: false,
                            nationalMode: false,
                            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
                        });
                    
                        if (localStorage.getItem('phone_number')) {
                            iti.setNumber(localStorage.getItem('phone_number'));
                            hiddenInput.value = localStorage.getItem('phone_number');
                        }
                    
                        function updatePhoneNumber() {
                            var phoneNumber = iti.getNumber();
                            hiddenInput.value = phoneNumber;
                            localStorage.setItem('phone_number', phoneNumber);
                    
                            var selectedCountry = iti.getSelectedCountryData().iso2;
                            localStorage.setItem('phone_country', selectedCountry);
                        }
                    
                        input.addEventListener("change", updatePhoneNumber);
                        input.addEventListener("keyup", updatePhoneNumber);
                    
                        document.querySelector("form").addEventListener("submit", function(event) {
                            if (input.value.trim() === '') {
                                iti.setCountry("sy");
                                updatePhoneNumber();
                            }
                        });
                    </script>

                    <div id="car-fields" style="display: none;">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ translate('Year of manufacture') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="1900" step="1"
                                       placeholder="{{ translate('Year of manufacture') }}" name="manufacture" class="form-control" id="manufacture">
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                <i class="fas fa-book mr-2"></i>
                                {{ translate('Registration year') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="1900" step="1"
                                       placeholder="{{ translate('Registration year') }}" name="registration" class="form-control" id="registration">
                            </div>
                        </div>
                    </div>
                
                    <!-- Barcode -->
                    @if (addon_is_activated('pos_system'))
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-barcode mr-2"></i>
                            {{translate('Barcode')}}
                        </label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="barcode"
                                placeholder="{{ translate('Barcode') }}" value="{{ $product->barcode }}">
                        </div>
                    </div>
                    @endif
                </div>
                
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-images mr-2"></i>
                        {{translate('Product Images')}}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ translate('High-quality images help showcase your product better and attract more buyers. Add multiple clear and well-lit images.') }}
                    </p>
            
                    <!-- Gallery Images -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">
                            <i class="fas fa-image mr-2"></i>
                            {{translate('Gallery Images')}}
                        </label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photos" value="{{ $product->photos }}" class="selected-files">
                                <input type="hidden" name="meta_img" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                            <small class="text-muted">
                                {{translate('Recommended dimensions: 900x900 pixels or higher.')}}
                            </small>
                        </div>
                    </div>
            
                    <!-- Thumbnail Image -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">
                            <i class="fas fa-file-image mr-2"></i>
                            {{translate('Thumbnail Image')}}
                        </label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="thumbnail_img" value="{{ $product->thumbnail_img }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                            <small class="text-muted">
                                {{translate('Recommended dimensions: 195x195 pixels. Ensure the main object is centered and has some blank space around it for better responsiveness.')}}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-video mr-2"></i>
                        {{translate('Product Videos')}}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ translate('Add a video to highlight the features of your product. This can help attract more buyers.') }}
                    </p>
            
                    <!-- Video Provider -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-play-circle mr-2"></i>
                            {{translate('Video Provider')}}
                        </label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
                                <option value="youtube" <?php if($product->video_provider == 'youtube') echo "selected";?>>
                                    {{translate('Youtube')}}
                                </option>
                                <option value="dailymotion" <?php if($product->video_provider == 'dailymotion') echo "selected";?>>
                                    {{translate('Dailymotion')}}
                                </option>
                                <option value="vimeo" <?php if($product->video_provider == 'vimeo') echo "selected";?>>
                                    {{translate('Vimeo')}}
                                </option>
                            </select>
                        </div>
                    </div>
            
                    <!-- Video Link -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-link mr-2"></i>
                            {{translate('Video Link')}}
                        </label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="video_link" value="{{ $product->video_link }}"
                                placeholder="{{ translate('Video Link') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-layer-group mr-2"></i>
                        {{translate('Product Variation')}}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ translate('Define product variations such as colors, sizes, or other attributes to better showcase your product.') }}
                    </p>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">
                            <i class="fas fa-palette mr-2"></i>
                            {{ translate('Colors') }}
                        </label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" data-live-search="true"
                                data-selected-text-format="count" name="colors[]" id="colors" multiple>
                                @foreach (\App\Models\Color::orderBy('name', 'asc')->get() as $key => $color)
                                <option value="{{ $color->code }}"
                                    data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>"
                                    <?php if(in_array($color->code, json_decode($product->colors))) echo 'selected'?>></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" type="checkbox" name="colors_active"
                                    <?php if(count(json_decode($product->colors)) > 0) echo "checked";?>>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">
                            <i class="fas fa-cogs mr-2"></i>
                            {{ translate('Attributes') }}
                        </label>
                        <div class="col-lg-8">
                            <select name="choice_attributes[]" data-live-search="true" data-selected-text-format="count"
                                id="choice_attributes" class="form-control aiz-selectpicker" multiple
                                data-placeholder="{{ translate('Choose Attributes') }}">
                                @foreach (\App\Models\Attribute::all() as $key => $attribute)
                                <option value="{{ $attribute->id }}" @if($product->attributes != null &&
                                    in_array($attribute->id, json_decode($product->attributes, true))) selected
                                    @endif>{{ $attribute->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <p>{{ translate('Choose the attributes of this product and then input values of each attribute') }}</p>
                        <br>
                    </div>

                    <div class="customer_choice_options" id="customer_choice_options">
                        @foreach (json_decode($product->choice_options) as $key => $choice_option)
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <input type="hidden" name="choice_no[]" value="{{ $choice_option->attribute_id }}">
                                <input type="text" class="form-control" name="choice[]"
                                    value="{{ \App\Models\Attribute::find($choice_option->attribute_id)->getTranslation('name') }}"
                                    placeholder="{{ translate('Choice Title') }}" disabled>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker attribute_choice" data-live-search="true" name="choice_options_{{ $choice_option->attribute_id }}[]" multiple>
                                    @foreach (\App\Models\AttributeValue::where('attribute_id', $choice_option->attribute_id)->get() as $row)
                                        <option value="{{ $row->value }}" @if( in_array($row->value, $choice_option->values)) selected @endif>
                                            {{ translate($row->value) }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control aiz-tag-input" name="choice_options_{{ $choice_option->attribute_id }}[]" placeholder="{{ translate('Enter choice values') }}" value="{{ implode(',', $choice_option->values) }}" data-on-change="update_sku"> --}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-money-bill-alt mr-2"></i>
                        {{ translate('Product Price') }}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ translate('Set a competitive price to attract buyers and ensure a quick sale.') }}
                    </p>
            
                    <!-- Unit Price -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-dollar-sign mr-2"></i>
                            {{ translate('Unit Price') }}
                        </label>
                        <div class="col-lg-6">
                            <input type="text" placeholder="{{ translate('Unit price') }}" name="unit_price" class="form-control"
                                value="{{ $product->unit_price }}" required>
                        </div>
                    </div>
            
                    <!-- Discount -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-percent mr-2"></i>
                            {{ translate('Discount') }}
                        </label>
                        <div class="col-lg-6">
                            <input type="number" lang="en" min="0" step="0.01" placeholder="{{ translate('Discount') }}"
                                name="discount" class="form-control" value="{{ $product->discount }}" required>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control aiz-selectpicker" name="discount_type" required>
                                <option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?>>
                                    {{ translate('Flat') }}
                                </option>
                                <option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?>>
                                    {{ translate('Percent') }}
                                </option>
                            </select>
                        </div>
                    </div>
            
                    <!-- Hidden Stock Value -->
                    <div id="show-hide-div" style="display: none;">
                        <input type="hidden" name="current_stock" value="1">
                    </div>
            
                    <div class="sku_combination" id="sku_combination"></div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-align-left mr-2"></i>
                        {{ translate('Product Description') }}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ translate('A detailed and clear description helps buyers understand the features and value of your product.') }}
                    </p>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">
                            <i class="fas fa-pen-nib mr-2"></i>
                            {{ translate('Description') }} 
                            <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i>
                        </label>
                        <div class="col-lg-9">
                            <textarea class="aiz-text-editor"
                                name="description">{{ $product->getTranslation('description', $lang) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('PDF Specification')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('PDF Specification')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="pdf" value="{{ $product->pdf }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('SEO Meta Tags')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Meta Title')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}"
                                placeholder="{{translate('Meta Title')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Description')}}</label>
                        <div class="col-lg-8">
                            <textarea name="meta_description" rows="8"
                                class="form-control">{{ $product->meta_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Meta Images')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="meta_img" value="{{ $product->meta_img }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">{{translate('Slug')}}</label>
                        <div class="col-lg-8">
                            <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug"
                                value="{{ $product->slug }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div> --}}
            <input type="hidden" id="slug" name="slug"
                                value="{{ $product->slug }}" class="form-control">

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
                                    <input type="checkbox" name="refundable" value="1" @if ($product->refundable == 1) checked @endif onchange="isRefundable()">
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="w-100 refund-block @if($product->refundable != 1) d-none @endif">
                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <input type="hidden" name="refund_note_id" id="refund_note_id" value="{{ $product->refund_note_id }}">
                                    
                                    <h5 class="fs-14 fw-600 mb-3 mt-4 pb-3" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Refund Note')}}</h5>
                                    <div id="refund_note">
                                        @if($product->refundNote != null)
                                            <div class="border border-gray my-2 p-2">
                                                {{ $product->refundNote->getTranslation('description') ?? '' }}
                                            </div>
                                        @endif
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
                                <input type="checkbox" name="has_warranty" onchange="warrantySelection()" @if($product->has_warranty == 1) checked @endif> 
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="w-100 warranty_selection_div @if($product->has_warranty != 1) d-none @endif" >
                        <div class="form-group row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <select class="form-control aiz-selectpicker" 
                                    name="warranty_id" 
                                    id="warranty_id" 
                                    data-selected="{{ $product->warranty_id }}" 
                                    data-live-search="true"
                                    @if($product->has_warranty == 1) required @endif
                                >
                                    <option value="">{{ translate('Select Warranty') }}</option>
                                    @foreach (\App\Models\Warranty::all() as $warranty)
                                        <option value="{{ $warranty->id }}" @selected(old('warranty_id') == $warranty->id)>{{ $warranty->getTranslation('text') }}</option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="warranty_note_id" id="warranty_note_id" value="{{ $product->warranty_note_id }}">
                                
                                <h5 class="fs-14 fw-600 mb-3 mt-4 pb-3" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Warranty Note')}}</h5>
                                <div id="warranty_note">
                                    @if($product->warrantyNote != null)
                                        <div class="border border-gray my-2 p-2">
                                            {{ $product->warrantyNote->getTranslation('description') ?? '' }}
                                        </div>
                                    @endif
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
                        <div class="radio mar-btm mr-5 ml-4 d-flex align-items-center">
                            <input
                                id="fq_bought_select_products"
                                type="radio"
                                name="frequently_bought_selection_type"
                                value="product"
                                onchange="fq_bought_product_selection_type()"
                                @if($product->frequently_bought_selection_type == 'product') checked @endif
                            >
                            <label for="fq_bought_select_products" class="fs-14 fw-500 mb-0 ml-2">{{translate('Select Product')}}</label>
                        </div>
                        <div class="radio mar-btm mr-3 d-flex align-items-center">
                            <input
                                id="fq_bought_select_category"
                                type="radio"
                                name="frequently_bought_selection_type"
                                value="category"
                                onchange="fq_bought_product_selection_type()"
                                @if($product->frequently_bought_selection_type == 'category') checked @endif
                            >
                            <label for="fq_bought_select_category" class="fs-14 fw-500 mb-0 ml-2">{{translate('Select Category')}}</label>
                        </div>
                    </div> --}}

                    <div class="px-3 px-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="fq_bought_select_product_div d-none">
                                    @php
                                        $fq_bought_products = $product->frequently_bought_products()->where('category_id', null)->get();
                                    @endphp

                                    <div id="selected-fq-bought-products">
                                        @if(count($fq_bought_products) > 0)
                                            <div class="table-responsive mb-4">
                                                <table class="table aiz-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="opacity-50 pl-0">{{ translate('Product Thumb') }}</th>
                                                            <th class="opacity-50">{{ translate('Product Name') }}</th>
                                                            <th class="opacity-50">{{ translate('Category') }}</th>
                                                            <th class="opacity-50 text-right pr-0">{{ translate('Options') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($fq_bought_products as $fQBproduct)
                                                            <tr class="remove-parent">
                                                                <input type="hidden" name="fq_bought_product_ids[]" value="{{ $fQBproduct->frequently_bought_product->id }}">
                                                                <td class="w-150px pl-0" style="vertical-align: middle;">
                                                                    <p class="d-block size-48px">
                                                                        <img src="{{ uploaded_asset($fQBproduct->frequently_bought_product->thumbnail_img) }}" alt="{{ translate('Image')}}"
                                                                            class="h-100 img-fit lazyload" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                    </p>
                                                                </td>
                                                                <td style="vertical-align: middle;">
                                                                    <p class="d-block fs-13 fw-700 hov-text-primary mb-1 text-dark" title="{{ translate('Product Name') }}">
                                                                        {{ $fQBproduct->frequently_bought_product->getTranslation('name') }}
                                                                    </p>
                                                                </td>
                                                                <td style="vertical-align: middle;">{{ $fQBproduct->frequently_bought_product->main_category->name ?? translate('Category Not Found') }}</td>
                                                                <td class="text-right pr-0" style="vertical-align: middle;">
                                                                    <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                                                                        <i class="las la-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-block border border-dashed hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                        onclick="showFqBoughtProductModal()">
                                        <i class="las la-plus"></i>
                                        <span class="ml-2">{{ translate('Add More') }}</span>
                                    </button>
                                </div>

                                {{-- Select Category for Frequently Bought Product --}}
                                <div class="fq_bought_select_category_div d-none">
                                    @php
                                        $fq_bought_product_category_id = $product->frequently_bought_products()->where('category_id','!=', null)->first();
                                        $fqCategory = $fq_bought_product_category_id != null ? $fq_bought_product_category_id->category_id : null;

                                    @endphp
                                    <div class="form-group row">
                                        <label class="col-md-2 col-from-label">{{translate('Category')}}</label>
                                        <div class="col-md-10">
                                            <select
                                                class="form-control aiz-selectpicker"
                                                data-placeholder="{{ translate('Select a Category')}}"
                                                name="fq_bought_product_category_id"
                                                data-live-search="true"
                                                data-selected="{{ $fqCategory }}"
                                            >
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
                        </div>
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
                            <span class="main-category-info bg-soft-info p-2 position-absolute d-none border">{{ translate('This will be used for commission based calculations and homepage category wise product Show') }}</span>
                        </span>
                    </h6>
                </div>
                <div class="card-body ">
                    <div class="h-300px overflow-auto c-scrollbar-light">
                        @php
                            $old_categories = $product->categories()->pluck('category_id')->toArray();
                        @endphp
                        <ul class="hummingbird-treeview-converter list-unstyled" data-checkbox-name="category_ids[]" data-radio-name="category_id">
                            @foreach ($categories as $category)
                            <li id="{{ $category->id }}">{{ $category->getTranslation('name') }}</li>
                                @foreach ($category->childrenCategories as $childCategory)
                                    @include('backend.product.products.child_category', ['child_category' => $childCategory])
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6" class="dropdown-toggle" data-toggle="collapse" data-target="#collapse_2">
                        {{translate('Shipping Configuration')}}
                    </h5>
                </div>
                <div class="card-body collapse show" id="collapse_2">
                    @if (get_setting('shipping_type') == 'product_wise_shipping')
                    <div class="form-group row">
                        <label class="col-lg-6 col-from-label">{{translate('Free Shipping')}}</label>
                        <div class="col-lg-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="radio" name="shipping_type" value="free" @if($product->shipping_type == 'free')
                                checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-6 col-from-label">{{translate('Flat Rate')}}</label>
                        <div class="col-lg-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="radio" name="shipping_type" value="flat_rate" @if($product->shipping_type ==
                                'flat_rate') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="flat_rate_shipping_div" style="display: none">
                        <div class="form-group row">
                            <label class="col-lg-6 col-from-label">{{translate('Shipping cost')}}</label>
                            <div class="col-lg-6">
                                <input type="number" lang="en" min="0" value="{{ $product->shipping_cost }}" step="0.01"
                                    placeholder="{{ translate('Shipping cost') }}" name="flat_shipping_cost"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-6 col-from-label">{{translate('Is Product Quantity Mulitiply')}}</label>
                        <div class="col-md-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" name="is_quantity_multiplied" value="1" @if($product->is_quantity_multiplied == 1) checked @endif>
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
                    <h5 class="mb-0 h6">{{translate('Low Stock Quantity Warning')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">
                            {{translate('Quantity')}}
                        </label>
                        <input type="number" name="low_stock_quantity" value="{{ $product->low_stock_quantity }}" min="0"
                            step="1" class="form-control">
                    </div>
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">
                        {{translate('Stock Visibility State')}}
                    </h5>
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-6 col-from-label">{{translate('Show Stock Quantity')}}</label>
                        <div class="col-md-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="radio" name="stock_visibility_state" value="quantity"
                                    @if($product->stock_visibility_state == 'quantity') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-6 col-from-label">{{translate('Show Stock With Text Only')}}</label>
                        <div class="col-md-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="radio" name="stock_visibility_state" value="text"
                                    @if($product->stock_visibility_state == 'text') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-6 col-from-label">{{translate('Hide Stock')}}</label>
                        <div class="col-md-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="radio" name="stock_visibility_state" value="hide"
                                    @if($product->stock_visibility_state == 'hide') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Cash On Delivery')}}</h5>
                </div>
                <div class="card-body">
                    @if (get_setting('cash_payment') == '1')
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{translate('Status')}}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="cash_on_delivery" value="1"
                                            @if($product->cash_on_delivery == 1) checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
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
                    <h5 class="mb-0 h6">{{translate('Estimate Shipping Time')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">
                            {{translate('Shipping Days')}}
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="est_shipping_days"
                                value="{{ $product->est_shipping_days }}" min="1" step="1" placeholder="{{translate('Shipping Days')}}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">{{translate('Days')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('VAT & Tax')}}</h5>
                </div>
                <div class="card-body">
                    @foreach(\App\Models\Tax::where('tax_status', 1)->get() as $tax)
                    <label for="name">
                        {{$tax->name}}
                        <input type="hidden" value="{{$tax->id}}" name="tax_id[]">
                    </label>

                    @php
                        $tax_amount = 0;
                        $tax_type = '';
                        foreach($tax->product_taxes as $row) {
                            if($product->id == $row->product_id) {
                                $tax_amount = $row->tax;
                                $tax_type = $row->tax_type;
                            }
                        }
                    @endphp

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="number" lang="en" min="0" value="{{ $tax_amount }}" step="0.01"
                                placeholder="{{ translate('Tax') }}" name="tax[]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control aiz-selectpicker" name="tax_type[]">
                                <option value="amount" @if($tax_type=='amount' ) selected @endif>
                                    {{translate('Flat')}}
                                </option>
                                <option value="percent" @if($tax_type=='percent' ) selected @endif>
                                    {{translate('Percent')}}
                                </option>
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
                    class="btn btn-primary">{{ translate('Update Product') }}</button>
            </div>
        </div>
    </div>
</form>

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
        const oldCategoryId = "{{ $product->category_id ?? '' }}";
        const oldBrandId = "{{ $product->brand_id ?? '' }}";
        const oldModelId = "{{ $product->model_id ?? '' }}";

        function fetchBrands(categoryId, selectedBrandId = null) {
            if (categoryId) {
                $.ajax({
                    url: '{{ route('get-brands-by-category') }}',
                    method: 'GET',
                    data: { category_id: categoryId },
                    success: function (data) {
                        const brandSelect = $('#brand-select');
                        brandSelect.empty().append('<option value="">{{ translate("Select Brand") }}</option>');

                        if (data.length > 0) {
                            data.forEach(function (brand) {
                                const selected = (selectedBrandId == brand.id) ? 'selected' : '';
                                brandSelect.append(`<option value="${brand.id}" ${selected}>${brand.name}</option>`);
                            });
                        } else {
                            $('#brand-select').empty().append('<option value="">{{ translate('No Brands Available') }}</option>');
                            $('#brand-select').selectpicker('refresh');
                            $('#model-select').empty().append('<option value="">{{ translate('No Models Available') }}</option>');
                            $('#model-select').selectpicker('refresh');
                        }

                        brandSelect.selectpicker('refresh');
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            } else {
                $('#brand-select').empty().append('<option value="">{{ translate('Select Brand') }}</option>');
                $('#brand-select').selectpicker('refresh');
            }
        }

        // جلب النماذج بناءً على العلامة التجارية
        function fetchModels(brandId, selectedModelId = null) {
            if (brandId) {
                $.ajax({
                    url: '{{ route('get-models-by-brand') }}',
                    method: 'GET',
                    data: { brand_id: brandId },
                    success: function (data) {
                        const modelSelect = $('#model-select');
                        modelSelect.empty().append('<option value="">{{ translate("Select Model") }}</option>');

                        if (data.length > 0) {
                            data.forEach(function (model) {
                                const selected = (selectedModelId == model.id) ? 'selected' : '';
                                modelSelect.append(`<option value="${model.id}" ${selected}>${model.name}</option>`);
                            });
                        } else {
                            $('#model-select').empty().append('<option value="">{{ translate('No Models Available') }}</option>');
                            $('#model-select').selectpicker('refresh');
                        }

                        modelSelect.selectpicker('refresh');
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            }
        }

        // عند تغيير الفئة
        $('#category_id').on('change', function () {
            const categoryId = $(this).val();
            fetchBrands(categoryId); // جلب العلامات التجارية
            $('#model-select').empty().append('<option value="">{{ translate("Select Model") }}</option>').selectpicker('refresh'); // إعادة تعيين النماذج
        });

        // عند تغيير العلامة التجارية
        $('#brand-select').on('change', function () {
            const brandId = $(this).val();
            fetchModels(brandId); // جلب النماذج
        });

        // تعيين القيم المحفوظة عند تحميل الصفحة
        if (oldCategoryId) {
            $('#category_id').val(oldCategoryId).trigger('change');
            setTimeout(() => {
                if (oldBrandId) {
                    fetchBrands(oldCategoryId, oldBrandId);
                    setTimeout(() => {
                        if (oldModelId) {
                            fetchModels(oldBrandId, oldModelId);
                        }
                    }, 500); // مهلة قصيرة لضمان تحميل العلامات التجارية أولاً
                }
            }, 500); // مهلة قصيرة لضمان تحميل الفئة أولاً
        }
    });

    $(document).ready(function () {
        $('#category_id').on('change', function () {
            const selectedCategoryId = $(this).val();

            if (selectedCategoryId) {
                $.ajax({
                    url: '{{ route('seller.check-car-category') }}',
                    method: 'GET',
                    data: { category_id: selectedCategoryId },
                    success: function (response) {
                        if (response.isCarCategory) {
                            $('#car-fields').slideDown();
                        } else {
                            $('#car-fields').slideUp();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            } else {
                $('#car-fields').slideUp();
            }
        });
    });

    $(document).ready(function (){
        show_hide_shipping_div();

        $("#treeview").hummingbird();
        var main_id = '{{ $product->category_id != null ? $product->category_id : 0 }}';
        
        if (selected_ids != '') {
            const myArray = selected_ids.split(",");
            for (let i = 0; i < myArray.length; i++) {
                const element = myArray[i];
                $('#treeview input:checkbox#'+element).prop('checked',true);
                $('#treeview input:checkbox#'+element).parents( "ul" ).css( "display", "block" );
                $('#treeview input:checkbox#'+element).parents( "li" ).children('.las').removeClass( "la-plus" ).addClass('la-minus');
            }
        }
        $('#treeview input:radio[value='+main_id+']').prop('checked',true);
        fq_bought_product_selection_type();
    });

    $("[name=shipping_type]").on("change", function (){
        show_hide_shipping_div();
    });

    function show_hide_shipping_div() {
        var shipping_val = $("[name=shipping_type]:checked").val();

        $(".flat_rate_shipping_div").hide();

        if(shipping_val == 'flat_rate'){
            $(".flat_rate_shipping_div").show();
        }
    }


    function add_more_customer_choice_option(i, name){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            url:'{{ route('seller.products.add-more-choice-option') }}',
            data:{
               attribute_id: i
            },
            success: function(data) {
                var obj = JSON.parse(data);
                $('#customer_choice_options').append('\
                <div class="form-group row">\
                    <div class="col-md-3">\
                        <input type="hidden" name="choice_no[]" value="'+i+'">\
                        <input type="text" class="form-control" name="choice[]" value="'+name+'" placeholder="{{ translate('Choice Title') }}" readonly>\
                    </div>\
                    <div class="col-md-8">\
                        <select class="form-control aiz-selectpicker attribute_choice" data-live-search="true" name="choice_options_'+ i +'[]" multiple>\
                            '+obj+'\
                        </select>\
                    </div>\
                </div>');
                AIZ.plugins.bootstrapSelect('refresh');
           }
       });


    }

    $('input[name="colors_active"]').on('change', function() {
        if(!$('input[name="colors_active"]').is(':checked')){
            $('#colors').prop('disabled', true);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        else{
            $('#colors').prop('disabled', false);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        update_sku();
    });


    $('input[name="colors_active"]').on('change', function() {
        if(!$('input[name="colors_active"]').is(':checked')){
            $('#colors').prop('disabled', true);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        else{
            $('#colors').prop('disabled', false);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        update_sku();
    });

    $(document).on("change", ".attribute_choice",function() {
        update_sku();
    });

    $('#colors').on('change', function() {
        update_sku();
    });

    function delete_row(em){
        $(em).closest('.form-group').remove();
        update_sku();
    }

    function delete_variant(em){
        $(em).closest('.variant').remove();
    }

    function update_sku(){
        $.ajax({
           type:"POST",
           url:'{{ route('seller.products.sku_combination_edit') }}',
           data:$('#choice_form').serialize(),
           success: function(data){
               $('#sku_combination').html(data);
               setTimeout(() => {
                        AIZ.uploader.previewGenerate();
                }, "2000");
               if (data.trim().length > 1) {
                   $('#show-hide-div').hide();
                   AIZ.plugins.sectionFooTable('#sku_combination');
               }
               else {
                    $('#show-hide-div').show();
               }
           }
       });
    }

    AIZ.plugins.tagify();


    $(document).ready(function(){
        update_sku();

        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });
    });

    $('#choice_attributes').on('change', function() {
        $.each($("#choice_attributes option:selected"), function(j, attribute){
            flag = false;
            $('input[name="choice_no[]"]').each(function(i, choice_no) {
                if($(attribute).val() == $(choice_no).val()){
                    flag = true;
                }
            });
            if(!flag){
                add_more_customer_choice_option($(attribute).val(), $(attribute).text());
            }
        });

        var str = @php echo $product->attributes @endphp;

        $.each(str, function(index, value){
            flag = false;
            $.each($("#choice_attributes option:selected"), function(j, attribute){
                if(value == $(attribute).val()){
                    flag = true;
                }
            });
            if(!flag){
                $('input[name="choice_no[]"][value="'+value+'"]').parent().parent().remove();
            }
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
        var productID = $('input[name=id]').val();
        var searchKey = $('input[name=search_keyword]').val();
        var fqBroughCategory = $('select[name=fq_brough_category]').val();
        $.post('{{ route('seller.product.search') }}', { _token: AIZ.data.csrf, product_id: productID, search_key:searchKey, category:fqBroughCategory, product_type:"physical" }, function(data){
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
@endsection

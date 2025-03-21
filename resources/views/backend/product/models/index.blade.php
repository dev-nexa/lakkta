@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3">{{translate('All Models')}}</h1>
	</div>
</div>

<div class="row">
	<div class="@if(auth()->user()->can('add_brand')) col-lg-7 @else col-lg-12 @endif">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Models') }}</h5>
				</div>
				<div class="col-md-4">
					<form class="" id="sort_models" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table aiz-table mb-0">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>{{translate('Name')}}</th>
		                    <th>{{translate('Brand')}}</th>
		                    <th class="text-right">{{translate('Options')}}</th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($models as $key => $model)
		                    <tr>
		                        <td>{{ ($key+1) + ($models->currentPage() - 1)*$models->perPage() }}</td>
		                        <td>{{ translate($model->name) }}</td>
		                        <td>{{ $model->brand ? $model->brand->name : translate('No Brand') }}</td>
		                        <td class="text-right">
									@can('edit_brand')
										<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('models.edit', ['id'=>$model->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
											<i class="las la-edit"></i>
										</a>
									@endcan
									@can('delete_brand')
										<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('models.destroy', $model->id)}}" title="{{ translate('Delete') }}">
											<i class="las la-trash"></i>
										</a>
									@endcan
		                        </td>
		                    </tr>
		                @endforeach
		            </tbody>
		        </table>
		        <div class="aiz-pagination">
                	{{ $models->appends(request()->input())->links() }}
            	</div>
		    </div>
		</div>
	</div>
	@can('add_brand')
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0 h6">{{ translate('Add New Model') }}</h5>
				</div>
				<div class="card-body">
					<form action="{{ route('models.store') }}" method="POST">
						@csrf
						<div class="form-group mb-3">
							<label for="name">{{translate('Name')}}</label>
							<input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control" required>
						</div>
						<div class="form-group mb-3">
							<label for="brand">{{ translate('Brand') }}</label>
							
							<select id="brand-select" name="brand" class="select2 form-control aiz-selectpicker" data-toggle="select2" data-placeholder="Choose ..."data-live-search="true"  required>
								@foreach ($brands as $brand)
									<option value="{{ $brand->id }}">{{ $brand->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group mb-3 text-right">
							<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endcan
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
    function sort_models(el){
        $('#sort_models').submit();
    }
</script>
@endsection

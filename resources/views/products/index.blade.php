@extends('layouts.master')
@section('title')
	المنتجات
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Add'))
<div class="row">
	<div class="col">
		<div class="alert alert-success alert-dismissible fade show">
			<strong>{{ session()->get('Add') }}</strong>
		</div>
	</div>

</div>
@endif
@if (session()->has('Edit'))
<div class="row">
	<div class="col">
		<div class="alert alert-success alert-dismissible fade show">
			<strong>{{ session()->get('Edit') }}</strong>
		</div>
	</div>

</div>
@endif
@if (session()->has('Delete'))
<div class="row">
	<div class="col">
		<div class="alert alert-success alert-dismissible fade show">
			<strong>{{ session()->get('Delete') }}</strong>
		</div>
	</div>

</div>
@endif
@if ($errors->any())
<div class="row">
	<div class="col">
		<div class="alert alert-danger alert-dismissible fade show">
			@foreach ($errors->all() as $error)
				
			<strong>{{ $error }}</strong>
			<br>
			@endforeach
		</div>
	</div>

</div>
@endif

				<!-- row -->
<div class="row">

					<div class="col-xl-12">
					
					<a class="btn ripple btn-primary my-3 text-cetner" data-target="#modaldemo1" data-toggle="modal" href="#modaldemo1">اضافه منتج</a>
				
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">جدول المنتجات</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
								{{-- <p class="tx-12 tx-gray-500 mb-2"> <a href="">Learn more</a></p> --}}
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons ">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم المنتج</th>
												<th class="border-bottom-0">اسم القسم</th>
												<th class="border-bottom-0"> الوصف</th>
												<th class="border-bottom-0">تحكم</th>
												<th class="border-bottom-0">العمليات</th>
										
											</tr>
										</thead>
										<tbody>
											@foreach ($data as $item )
											<tr>
												<td>{{ $item->id }}</td>
												<td>{{ $item->product_name }}</td>
												<td>{{ $item->section->section_name }}</td>
												<td>{{ $item->description }}</td>
												<td>
													<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
													data-id="{{ $item->id }}" data-product_name="{{ $item->product_name }}"
													data-description="{{ $item->description }}" data-toggle="modal" href="#exampleModal2" data-section_id="{{ $item->section_id }}"
													title="تعديل"><i class="las la-pen"></i></a>

												 <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
													data-id="{{ $item->id }}" data-product_name="{{ $item->product_name }}" data-toggle="modal"
													href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
												</td>
												<td>{{ $item->created_at }}</td>
										
											</tr>
											@endforeach
											
											
										</tbody>
									</table>
								</div>
								{{-- Add Section --}}
								<div class="modal" id="modaldemo1">
									<div class="modal-dialog" role="document">
										<div class="modal-content modal-content-demo">
											<div class="modal-header">
												<h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
											</div>
											<div class="modal-body">
												<form action="{{ route('products.store') }}" method="post">
													@csrf
													<div class="form-grpup">
														<label >اسم المنتج</label>
														<input type="text" class="form-control" id="product_name" name="product_name"> 
													</div>
													<br>
												<div class="form-grpup">
													<label for="">اختار القسم</label>
													<select class="form-control" name="section_id" id="section_id">
														@foreach ($sections as $section)
															
														<option value="{{ $section->id }}">{{ $section->section_name }}</option>
														@endforeach
													</select>
													 
												</div>
												<br>
												<div class="form-grpup">
													<label >الملاحظات</label>
														<textarea class="form-control" name="description" id="description"  rows="3"></textarea>
												</div>

											</div>
											<div class="modal-footer">
												<button type="submit" class="btn ripple btn-primary" type="button">تاكيد</button>
												<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
											</div>
										</form>
										</div>
									</div>
								</div>
								{{-- End Add Section --}}



								{{-- Edit Section --}}
								<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
								aria-hidden="true">
							   <div class="modal-dialog" role="document">
								   <div class="modal-content">
									   <div class="modal-header">
										   <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
										   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											   <span aria-hidden="true">&times;</span>
										   </button>
									   </div>
									   <div class="modal-body">
   
										   <form action="products/update" method="post" autocomplete="off">
											  @csrf
											  @method('put')
											   <div class="form-group">
												   <input type="hidden" name="id" id="id" value="">
												   <label for="recipient-name" class="col-form-label">اسم المنتج:</label>
												   <input class="form-control" name="product_name" id="product_name" type="text">
											   </div>
											   <br>
											   <div class="form-grpup">
												   <label for="">اختار القسم</label>
												   <select class="form-control" name="section_id" id="section_id">
													   @foreach ($sections as $section)
														   
													   <option  value="{{ $section->id }}">{{ $section->section_name }}</option>
													   @endforeach
												   </select>
													
											   </div>
											   <br>
											   <div class="form-group">
												   <label for="message-text" class="col-form-label">ملاحظات:</label>
												   <textarea class="form-control" id="description" name="description"></textarea>
											   </div>
									   </div>
									   <div class="modal-footer">
										   <button type="submit" class="btn btn-primary">تاكيد</button>
										   <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
									   </div>
									   </form>
								   </div>
							   </div>
						   </div>

								{{-- End Edit Section --}}

								{{-- Delete Section--}}
								<div class="modal" id="modaldemo9">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content modal-content-demo">
											<div class="modal-header">
												<h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
																							   type="button"><span aria-hidden="true">&times;</span></button>
											</div>
											<form action="products/destroy" method="post">
												@csrf
												@method('delete')
												<div class="modal-body">
													<p>هل انت متاكد من عملية الحذف ؟</p><br>
													<input type="hidden" name="id" id="id" value="">
													<input class="form-control" name="product_name" id="product_name" type="text" readonly>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
													<button type="submit" class="btn btn-danger">تاكيد</button>
												</div>
										</div>
										</form>
									</div>
								</div>
			

								{{-- End Delete Section--}}
							</div>
						</div>
					</div>
					

					
				



		
		</div>
	
@endsection











@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
{{-- Models --}}
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var product_name = button.data('product_name')
		var description = button.data('description')
		var section_id = button.data('section_id')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #product_name').val(product_name);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #section_id').val(section_id);
	})
</script>

<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var product_name = button.data('product_name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #product_name').val(product_name);
	})
</script>

@endsection
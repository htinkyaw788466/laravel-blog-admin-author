@extends('layouts.backend.app')

@section('title','Subscriber')

@push('css')
  <link href="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')

  <div class="container-fluid">
            <div class="block-header">



     @if(session('alertMsg'))

     <div class="alert alert-danger" roles="alert">
     {{ session('alertMsg') }}

     </div>
     @endif


            </div>
            <!-- Basic Examples -->

            <!-- #END# Basic Examples -->
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              ALL SUBSCRIBER
                               <span class="badge bg-red">{{ $subs->count() }} </span>
                            </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                              <th>ID</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                    	@foreach($subs as $key=>$sub)
                                    	 <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $sub->email  }}</td>

                                            <td>{{ $sub->created_at->diffForHumans() }}</td>
                                            <td>{{ $sub->updated_at->diffForHumans() }}</td>
                                            <td class="text-center">

       <button class="btn btn-danger waves-effect" type="button" onclick="deleteSubscriber({{ $sub->id }})">
              	<i class="material-icons">delete</i>
              </button>

              <form id="delete-form-{{ $sub->id }}" action="{{ route('admin.subscriber.destroy',$sub->id) }}" method="POST" style="display: none;">
              	@csrf
              	@method('DELETE')

              </form>


                                             </td>

                                        </tr>
                                   @endforeach
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>

@endsection

@push('js')
 <!-- Jquery DataTable Plugin Js -->
    <script src=" {{ asset('public/assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}  "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }} "></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }} "></script>

    <!-- Custom Js -->

    <script src="{{ asset('public/assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">

    function deleteSubscriber(id){
    	const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {

     event.preventDefault();
     document.getElementById('delete-form-'+id).submit();

  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Your imaginary file is safe :)',
      'error'
    )
  }
})
    }

    </script>
@endpush

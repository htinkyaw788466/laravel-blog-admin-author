@extends('layouts.backend.app')

@section('title','all posts')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}"
        rel="stylesheet">
@endpush

@section('content')

    <div class="container-fluid">
        <div class="block-header">

            <a class="btn btn-primary waves-effect" href="{{ route('author.post.create') }}">
                <i class="material-icons">add</i>
                <span> Add New Post </span> </a>

                <br>

            @if (session('successMsg'))
                <div class="alert alert-success" roles="alert">
                    {{ session('successMsg') }}

                </div>
            @endif

            @if (session('alertMsg'))
                <div class="alert alert-danger" roles="alert">
                    {{ session('alertMsg') }}

                </div>
            @endif


        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL Posts
                            <span class="badge bg-red">{{ $posts->count() }}

                            </span>
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th><i class="material-icons">visibility</i></th>
                                        <th>In Approved</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>

                                </tfoot>

                                <tbody>
                                    @foreach ($posts as $key => $post)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ str_limit($post->title,'15') }}</td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>{{ $post->view_count }}</td>
                                            <td>
                                                @if ($post->is_approved==true)
                                                   <span class="badge bg-blue">Approved</span>
                                                @else
                                                    <span class="badge bg-pink">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($post->status==true)
                                                   <span class="badge bg-blue">Published</span>
                                                @else
                                                    <span class="badge bg-pink">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $post->created_at->diffForHumans() }}</td>
                                            <td>{{ $post->updated_at->diffForHumans() }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('author.post.show',$post->id) }}" class="btn btn-info waves-effect">
                                                    <i class="material-icons">visibility</i>
                                                  </a>
                                                <a href="{{ route('author.post.edit',$post->id) }}" class="btn btn-info waves-effect">
                                                    <i class="material-icons">edit</i>
                                                </a>

                                                <a href="{{ route('author.post.destroy',$post->id) }}" class="btn btn-danger waves-effect">
                                                    <i class="material-icons">delete</i>
                                                </a>
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

    </div>


@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src=" {{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}  "></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }} ">
    </script>
    <script
        src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }} ">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }} ">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }} "></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }} "></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }} "></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }} ">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }} ">
    </script>

    <!-- Custom Js -->

    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>
@endpush

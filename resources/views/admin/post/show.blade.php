@extends('layouts.backend.app')

@section('title', 'Show Post')

@push('css')
@endpush



@section('content')
    <div class="container-fluid">

        <a href="{{ route('admin.post.index') }}" class="btn btn-danger wave-effect">BACK</a>

        @if ($post->is_approved == false)
            <button type="button" class="btn btn-success wave-effect pull-right" onclick="approvePost({{ $post->id }})">
                <i class="material-icons">done</i>
                <span>Approve</span>
            </button>
            <form method="POST" action="{{ route('admin.post.approve', $post->id) }}" id="approval-form"
                style="display: none;">
                @csrf
                @method('PUT')

            </form>
        @else
            <button type="button" class="btn btn-success pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>
        @endif

        <br>
        <br>

        <!-- #END# Vertical Layout -->
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ $post->title }}
                            <small>Posted By <strong><a href="">{{ $post->user->name }}</a> </strong> on
                                {{ $post->created_at->toFormattedDateString() }} </small>

                        </h2>


                    </div>
                    <div class="body">

                        {!! $post->body !!}



                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>
                            Categoryies

                        </h2>

                    </div>
                    <div class="body">

                        @foreach ($post->categories as $category)
                            <span class="label bg-cyan">{{ $category->name }}</span>
                        @endforeach


                    </div>
                </div>


                <div class="card">
                    <div class="header bg-green">
                        <h2>
                            Tags

                        </h2>

                    </div>
                    <div class="body">

                        @foreach ($post->tags as $tag)
                            <span class="label bg-green">{{ $tag->name }}</span>
                        @endforeach


                    </div>
                </div>
                <div class="card">
                    <div class="header bg-amber">
                        <h2>
                            Featured Image

                        </h2>

                    </div>
                    <div class="body">

                        <img class="img-responsive thumbnail"
                            src="{{ Storage::disk('public')->url('post/' . $post->image) }}">


                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection



@push('js')
    <!-- Select Plugin Js -->
    <script src="{{ asset('public/assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('public/assets/backend/plugins/tinymce/tinymce.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>



    <script type="text/javascript">
        $(function() {

            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('public/assets/backend/plugins/tinymce') }}';
        });



        function approvePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to approve this post",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    event.preventDefault();
                    document.getElementById('approval-form').submit();

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'The post remain Pending :)',
                        'info'
                    )
                }
            })
        }
    </script>
@endpush

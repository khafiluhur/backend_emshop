@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <div>
            <h3 class="content-title card-title">Daftar Kategori</h3>
            <p>Tambah, ubah atau hapus kategori</p>
        </div>
        <div>
            <a href="{{ url('/category/create') }}" class="btn btn-primary btn-sm rounded-3">+ Tambah Kategori</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" />
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Icon</th>
                                    <th>Image</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                @foreach ($category as $item)
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" />
                                        </div>
                                    </td>
                                    <td>{{ $i++ }}</td>
                                    <td><b>{{ $item->name }}</b></td>
                                    <td>/{{ $item->slug }}</td>
                                    <td>
                                        <img src="{{ url('assets/imgs/category') }}/{{ $item->icon }}" class="img-xs img-thumbnail" alt="icon" />
                                    </td>
                                    <td>
                                        <img src="{{ url('assets/imgs/category/') }}/{{ $item->img }}" class="img-md img-thumbnail" alt="banner" />
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('category.edit', ['id' => $item->id]) }}">Edit info</a>
                                                <a class="dropdown-item text-danger" href="{{ route('category.delete', ['id' => $item->id]) }}">Delete</a>
                                            </div>
                                        </div>
                                        <!-- dropdown //end -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- .col// -->
            </div>
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
    <!-- card .// -->
</section>
<!-- content-main end// -->
@endsection

@section('js')
<script>
    window.addEventListener('load', function() {
        document.getElementById('input-icon').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('icon');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url
            }
        });
        document.getElementById('input-banner').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('banner-category');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url
            }
        });
    });
</script>
@endsection
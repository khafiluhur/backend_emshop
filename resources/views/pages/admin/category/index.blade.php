@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <div>
            <h3 class="content-title card-title">Daftar Kategori</h3>
            <p>Tambah, ubah atau hapus kategori</p>
        </div>
        <div>
            <input type="text" placeholder="Search Categories" class="form-control bg-white" />
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Category name</label>
                            <input type="text" placeholder="Category Name" name="name" class="form-control" id="product_name" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Icon</label>
                            <div class="input-upload">
                                <img id="icon" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" />
                                <input id="input-icon" class="form-control" name="icon" type="file" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Image</label>
                            <div class="input-upload">
                                <img id="banner-category" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" />
                                <input id="input-banner" class="form-control" name="img" type="file" />
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">+ Tambah Kategori</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
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
                                                <a class="dropdown-item" href="#">View detail</a>
                                                <a class="dropdown-item" href="#">Edit info</a>
                                                <a class="dropdown-item text-danger" href="#">Delete</a>
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
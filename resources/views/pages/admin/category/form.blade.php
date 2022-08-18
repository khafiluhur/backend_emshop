@extends('layouts.full_app')

@section('css')
<style>
    .form-control, .form-select {
        background-color: white;
        font-size: 14px;
        border-radius: 8px
    }
    textarea.form-control {
        min-height: 200px
    }
    .has-error {
        border-color: red
    }
    .form-control:focus {
        border-color: #3BB77E !important;
    }
</style>
@endsection

@section('content')
<section class="content-main">
    <div class="row">
        @if($type == 'add')
            <form class="col-lg-12" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @else
            <form class="col-lg-12" action="{{ route('category.update',$category->id) }}" method="POST" enctype="multipart/form-data">
        @endif
        @csrf
        <div class="">
            <div class="content-header">
                <h3 class="content-title">{{$title}}</h3>
            </div>
        </div>
        <div class="">
            <div class="card mb-4">
                <div class="card-body row">
                    <div class="col-4">
                        <p class="fw-bolder">Banner Kategori<span class="badge bg-light">Wajib</span></p>
                        <p>Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran minimum 700 x 700 px).</p>
                    </div>
                    <div class="col-8">
                        <input id="input-banner" class="form-control" name="img" type="file" />
                        @if($type == 'add')
                            <img id="banner-image" class="w-25 my-3" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" />
                        @else
                            <img class="rounded mt-3" id="banner-image" src="{{ url('assets/imgs/category') }}/{{ $category->img }}" alt="" />
                        @endif
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-4">
                        <p class="fw-bolder">Icon Kategori<span class="badge bg-light">Wajib</span></p>
                        <p>Format gambar .png .svg dan ukuran minimum 56px x 56px.</p>
                    </div>
                    <div class="col-8">
                        
                        <input id="input-icon" class="form-control" name="icon" type="file" />
                        @if($type == 'add')
                            <img id="icon-image" class="my-3" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" style="width: 6%"/>
                        @else
                            <img class="rounded mt-3" id="icon-image" src="{{ url('assets/imgs/category') }}/{{ $category->icon }}" alt="" />
                        @endif
                    </div>
                </div>
                <div class="card-body row">
                    <div class="row mb-5">
                        <div class="col-4">
                            <p class="fw-bolder">Nama Kategori<span class="badge bg-light">Wajib</span></p>
                            <p>Cantumkan min. 40 karakter agar semakin menarik dan mudah ditemukan oleh pembeli.</p>
                        </div>
                        <div class="col-8">
                            @if($type == 'add')
                                <input type="text" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" name="name" onchange="checkValue()" id="name"/>
                            @else
                                <input type="text" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" name="name" onchange="checkValue()" id="name" value="{{ $category->name }}"/>
                            @endif
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="row mb-5">
                        <div class="col-4">
                            <p class="fw-bolder">Deskripsi Kategori<span class="badge bg-light">Wajib</span></p>
                        </div>
                        <div class="col-8">
                            @if($type == 'add')
                                <textarea class="form-control" name="description" rows="13"></textarea>
                            @else
                                <textarea class="form-control" name="description" rows="13">{{ $category->description }} </textarea>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="content-header">
                <h3 class="content-title"></h3>
                <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Batal</button>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Simpan & Tambah Baru</button>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Simpan</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script src="https://cdn.tiny.cloud/1/9wbq65wjxp5llidr4th4834q4q2qlsplbphrqdi7l08ey60t/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'link media',
    });
</script>
<script>
    window.addEventListener('load', function() {
        document.getElementById('input-banner').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('banner-image');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url
                img.classList.remove("w-25")

            }
        });
    });
    window.addEventListener('load', function() {
        document.getElementById('input-icon').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('icon-image');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url
            }
        });
    });
</script>
@endsection
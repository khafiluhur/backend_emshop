@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <div>
            <h3 class="content-title card-title">Daftar Merek</h3>
            <p>Merek dan manajemen vendor</p>
        </div>
        <div>
            <a href="{{ url('/brand/create') }}" class="btn btn-primary">+ Tambah Merek</a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 mb-lg-0 mb-15 me-auto">
                    <input type="text" placeholder="Search..." class="form-control" />
                </div>
                <div class="col-lg-2 col-6">
                    <div class="custom_select">
                        <select class="form-select select-nice">
                            <option selected>Categories</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="row gx-3">
                @foreach ($brand as $item)
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <figure class="card border-1">
                        <div class="card-header bg-white text-center">
                            <img height="76" src="{{ url('assets/imgs/brands') }}/{{ $item->img }}" class="img-fluid" alt="Logo" />
                        </div>
                        <figcaption class="card-body text-center">
                            <h6 class="card-title m-0">{{ $item->name }}</h6>
                            {{-- <a class="" href="#"> 398 items </a> --}}
                        </figcaption>
                    </figure>
                </div>
                <!-- col.// -->
                @endforeach
            </div>
            <!-- row.// -->
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
</section>
<!-- content-main end// -->
@endsection
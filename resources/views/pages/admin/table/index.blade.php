@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">{{$title}}</h2>
        </div>
        <div>
            @if ($slug == 'product')
            <a href="{{ url('/product/create') }}" class="btn btn-primary btn-sm rounded">Create new</a>
            @else
            <a href="{{ url('/banner/create') }}" class="btn btn-primary btn-sm rounded">Create new</a>
            @endif
        </div>
    </div>
    @if ($slug == 'product')
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col col-check flex-grow-0">
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="checkbox" value="" />
                    </div>
                </div>
                <div class="col-md-3 col-12 mb-md-0 mb-3">
                    <select class="form-select">
                        <option selected>All category</option>
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 me-auto">
                    <input type="text" placeholder="Search..." class="form-control" />
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select">
                        <option selected>Status</option>
                        <option value="1">Active</option>
                        <option value="2">Disabled</option>
                        <option value="3">Show all</option>
                    </select>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            @foreach ($product as $item)
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col col-check flex-grow-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                        <a class="itemside" href="#">
                            <div class="left">
                                <img src="{{ url('assets/imgs/products') }}/{{ $item->img }}" class="img-sm img-thumbnail" alt="Item" />
                            </div>
                            <div class="info">
                                <h6 class="mb-0">{{$item->name}}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-4 col-price"><span>Rp. {{$item->price}}</span></div>
                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                        @if ($item->status == 1)
                        <span class="badge rounded-pill alert-success">Active</span>
                        @elseif ($item->status == 2)
                        <span class="badge rounded-pill alert-danger">Disabled</span>
                        @else
                        <span class="badge rounded-pill alert-warning">Archived</span>
                        @endif
                    </div>
                    <div class="col-lg-1 col-sm-2 col-4 col-date">
                        <span>{{$item->sku}}</span>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                        <a href="{{ url('/product/edit') }}/{{$item->name}}" class="btn btn-sm font-sm rounded btn-brand"> <i class="material-icons md-edit"></i> Edit </a>
                        <a href="#" class="btn btn-sm font-sm btn-light rounded"> <i class="material-icons md-delete_forever"></i> Delete </a>
                    </div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            @endforeach
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                <li class="page-item"><a class="page-link" href="#">02</a></li>
                <li class="page-item"><a class="page-link" href="#">03</a></li>
                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">16</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    @else
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col col-check flex-grow-0 me-auto">
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="checkbox" value="" />
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <input type="date" value="02.05.2021" class="form-control" />
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select">
                        <option selected>Status</option>
                        <option value="1">Active</option>
                        <option value="2">Disabled</option>
                        <option value="3">Show all</option>
                    </select>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            @foreach ($banner as $item)
                <article class="itemlist">
                    <div class="row align-items-center">
                        <div class="col col-check flex-grow-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12 flex-grow-1 col-name">
                            <a class="itemside" href="#">
                                <div class="left">
                                    <img src="{{ url('assets/imgs/banners') }}/{{ $item->img }}" class="img-sm img-thumbnail" alt="Banner" />
                                </div>
                                <div class="info">
                                    <h6 class="mb-0">{{ $item->title }}</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-4 col-status">
                            @if ($item->status == 1)
                            <span class="badge rounded-pill alert-success">Active</span>
                            @elseif ($item->status == 2)
                            <span class="badge rounded-pill alert-danger">Disabled</span>
                            @else
                            <span class="badge rounded-pill alert-warning">Archived</span>
                            @endif
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-date">
                            <span>02.11.2021</span>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                            <a href="#" class="btn btn-sm font-sm rounded btn-brand"> <i class="material-icons md-edit"></i> Edit </a>
                            <a href="#" class="btn btn-sm font-sm btn-light rounded"> <i class="material-icons md-delete_forever"></i> Delete </a>
                        </div>
                    </div>
                    <!-- row .// -->
                </article>
            <!-- itemlist  .// -->
            @endforeach
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                <li class="page-item"><a class="page-link" href="#">02</a></li>
                <li class="page-item"><a class="page-link" href="#">03</a></li>
                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">16</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</section>
<!-- content-main end// -->
@endsection
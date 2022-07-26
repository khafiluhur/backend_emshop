@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<style>
    .form-control, .form-select {
        border-radius: 8px
    }
    .btn.btn-primary {
        border-radius: 8px !important
    }
    .searchform button {
        width: auto
    }
    .searchform input {
        max-width: initial
    }
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #3BB77E;
}

input:focus + .slider {
  box-shadow: 0 0 1px #3BB77E;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.btn-custome-secondary {
    border-color: #606060;
    padding: 0.375rem 2.75rem;
}
.dropdown-toggle::after {
    margin-left: 1.255em;
}
.dropdown-item.active, .dropdown-item:active {
    background-color: #3BB77E;
}
.dropdown-item:focus, .dropdown-item:hover {
    background-color: rgba(59, 183, 126, 0.075);
}
.form-custome-select {
    border-color: #606060;
}

.tooltip1 .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: white;
  box-shadow: 0 1px 6px 0 var(--color-shadow,rgba(49,53,59,0.12));
  color: black;
  text-align: center;
  border-radius: 6px;
  padding: 2px 10px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -60px;
}

.tooltip1 .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: white transparent transparent transparent;
}
.tooltip1:hover .tooltiptext {
  visibility: visible;
}
</style>
@endsection

@section('content')
<section class="content-main">
    <div class="content-header">
        <div>
            <h3 class="content-title card-title">{{$title}}</h3>
        </div>
        <div>
            @if ($slug == 'product')
            <a href="{{ url('/product/create') }}" class="btn btn-primary btn-sm rounded-3">+ Tambah Produk</a>
            @else
            <a href="{{ url('/banner/create') }}" class="btn btn-primary btn-sm rounded-3">+ Tambah Banner</a>
            @endif
        </div>
    </div>
    @if ($slug == 'product')
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-4 me-auto">
                    <input type="text" placeholder="Cari nama Produk dan SKU" class="form-control" />
                </div>
                <div class="col-md-3 col-12 mb-md-0 mb-3">
                    <select class="form-select form-custome-select">
                        <option selected>Kategori</option>
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
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
        <div class="card-body">
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-4 flex-grow-1 col-name">
                        <a class="itemside">
                            <div class="info">
                                <h6 class="mb-0">INFO PRODUK</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-price"><h6>HARGA</h6></div>
                    <div class="col-lg-2 col-status text-center">
                        <h6>STATISTIK</h6>
                    </div>
                    <div class="col-lg-2 col-status text-center">
                        <h6>STATUS</h6>
                    </div>
                    <div class="col-lg-2 col-action text-end text-center">
                       <h6></h6>
                    </div>
                </div>
            </article>
        </div>
        <!-- card-header end// -->
        <div class="card-body">
            @foreach ($product as $key => $item)
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-4 flex-grow-1 col-name">
                        <a class="itemside">
                            <div class="left">
                                <img src="{{ url('assets/imgs/products') }}/{{ $item['img'] }}" class="img-sm img-thumbnail" style="padding: 0" alt="Item" />
                            </div>
                            <div class="info">
                                <h6 class="mb-0">{{$item['name']}}</h6>
                                <p>SKU: {{$item['sku']}}</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-price">
                        @if($item['price'] != '0' && $item['disc'] != '0')
                        <p class="mb-0 fw-bold">Rp. {{$item['price']}}</p>
                        <p class="mb-0">
                            <span class="text-decoration-line-through">Rp. {{$item['disc_price']}}</span>
                            <span class="text-danger fw-bold">-{{$item['disc']}}%</span>
                        </p>
                        @else
                        <p class="mb-0 fw-bold">Rp. {{$item['disc_price']}}</p>
                        @endif
                    </div>
                    <div class="col-lg-2 col-status text-center">
                        <label class="tooltip1">
                            <span class="material-symbols-outlined">visibility</span>
                            <span class="position-absolute ml-2">{{$item['total_view']}}</span>
                            <span class="tooltiptext text-start">
                                <p style="margin-bottom: 0 !important">Aladin Mall : @if($item['aladin_mall'] != null ){{$item['aladin_mall']}}@else 0 @endif</p>
                                <p style="margin-bottom: 0 !important">Tokopedia : @if($item['tokopedia'] != null ){{$item['tokopedia']}}@else 0 @endif</p>
                                <p style="margin-bottom: 0 !important">Shopee : @if($item['shopee'] != null ){{$item['shopee']}}@else 0 @endif</p>
                                <p style="margin-bottom: 0 !important">Lazada : @if($item['lazada'] != null ){{$item['lazada']}}@else 0 @endif</p>
                                <p style="margin-bottom: 0 !important">Blibli : @if($item['blibli'] != null ){{$item['blibli']}}@else 0 @endif</p>
                                <p style="margin-bottom: 0 !important">Bukalapak : @if($item['bukalapak'] != null ){{$item['bukalapak']}}@else 0 @endif</p>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-2 col-status text-center">
                        @if($item['status'] == 1)
                        <label class="switch">
                            <input type="checkbox" class="toggle" onclick="toggleCheckbox({{$key}})" data-value="{{{$item['slug']}}}" data-active="1">
                            <span class="slider round"></span>
                        </label>
                        @else
                        <label class="switch">
                            <input type="checkbox" class="toggle" onclick="toggleCheckbox({{$key}})" data-value="{{{$item['slug']}}}" data-active="2" checked>
                            <span class="slider round"></span>
                        </label>
                        @endif
                    </div>
                    <div class="col-lg-2 col-action text-end">
                        <div class="dropdown">
                            <button class="btn btn-custome-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Atur
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="{{ url('/product/edit') }}/{{$item['slug']}}">Edit</a>
                              <a class="dropdown-item" href="{{ url('/product/delete') }}/{{$item['slug']}}">Hapus</a>
                            </div>
                          </div>
                    </div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            @endforeach
        </div>
        <!-- card-body end// -->
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
            @foreach ($banner as $key => $item)
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
                            @if($item['status'] == 1)
                            <label class="switch">
                                <input type="checkbox" class="toggle" onclick="toggleCheckboxBanner({{$key}})" data-value="{{{$item['slug']}}}" data-active="1">
                                <span class="slider round"></span>
                            </label>
                            @else
                            <label class="switch">
                                <input type="checkbox" class="toggle" onclick="toggleCheckboxBanner({{$key}})" data-value="{{{$item['slug']}}}" data-active="2" checked>
                                <span class="slider round"></span>
                            </label>
                            @endif
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-date">
                            <span>02.11.2021</span>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                            <a href="{{ url('/delete') }}/{{ $item->id }}" class="btn btn-sm font-sm rounded btn-brand"> <i class="material-icons md-edit"></i> Edit </a>
                            <a href="{{ url('/delete') }}/{{ $item->id }}" class="btn btn-sm font-sm btn-light rounded"> <i class="material-icons md-delete_forever"></i> Delete </a>
                        </div>
                    </div>
                    <!-- row .// -->
                </article>
            <!-- itemlist  .// -->
            @endforeach
        </div>
        <!-- card-body end// -->
    </div>
    @endif
</section>
<script>
    function toggleCheckbox(key)
    {
        var checkBox = document.getElementsByClassName("toggle")
        var parseHtml = Array.from(checkBox)
        var slug = parseHtml[key].dataset.value
        var active = parseHtml[key].dataset.active
        var status = ''
        if (active == 1){
            status = 2
            toggleStatus(slug, status)
        } else {
            status = 1
            toggleStatus(slug, status)
        }
    }
    
    function toggleStatus(slug, status)
    {
        var active = status
        var site = "{{url('')}}"
        var xhr = new XMLHttpRequest()
        var url = site+"/api/product/toggle/"+slug+"?status="+active
        xhr.open("GET", url, true)
        xhr.setRequestHeader("Authorization", "Bearer 1|3mTRZGnfTJ4wB0iX7LbAQbEKo6ZtQIbB56zxbNpA")
        xhr.send()

    }

    function toggleCheckboxBanner(key)
    {
     
        var checkBox = document.getElementsByClassName("toggle")
        var parseHtml = Array.from(checkBox)
        var slug = parseHtml[key].dataset.value
        var active = parseHtml[key].dataset.active
        var status = ''
        if (active == 1){
            status = 2
            toggleStatusBanner(slug, status)
        } else {
            status = 1
            toggleStatusBanner(slug, status)
        }
    }
    
    function toggleStatusBanner(slug, status)
    {
        var active = status
        var site = "{{url('')}}"
        var xhr = new XMLHttpRequest()
        var url = site+"/api/banner/toggle/"+slug+"?status="+active
        xhr.open("GET", url, true)
        xhr.setRequestHeader("Authorization", "Bearer 1|3mTRZGnfTJ4wB0iX7LbAQbEKo6ZtQIbB56zxbNpA")
        xhr.send()

    }
</script>
<!-- content-main end// -->
@endsection
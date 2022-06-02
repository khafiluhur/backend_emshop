@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="row">
        @if($slug == 'product')
        <form class="col-lg-12" action="{{ route('product.update',$product->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">{{$title}}</h2>
                <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Publich</button>
                </div>
            </div>
        </div>    
        <div class="col-lg-6 float-start me-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Basic</h4>
                </div>
                <div class="card-body">
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Product title</label>
                            <input type="text" placeholder="Product Name" class="form-control" name="name" id="product_name" value="{{ $product->name }}" />
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">SKU</label>
                            <input type="number" placeholder="SKU" class="form-control" name="sku" id="sku" value="{{ $product->sku }}" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea placeholder="Short Description"  class="form-control" name="short_desc" rows="4">{{ $product->short_desc }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Regular price</label>
                                    <div class="row gx-2">
                                        <input placeholder="Rp" type="text" name="price" class="form-control" id="rupiah_price" value="{{ $product->price }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Promotional price</label>
                                    <input placeholder="Rp" type="text" name="disc_price" class="form-control" id="rupiah_disc_price" value="{{ $product->disc_price }}" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Discount</label>
                                    <input placeholder="%" type="text" name="disc" class="form-control" value="{{ $product->disc }}" />
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Link</h4>
                </div>
                <div class="card-body">
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Aladin Mall</label>
                            <input type="text" placeholder="https://aladinmall.misteraladin.com/" name="aladin_mall" class="form-control" id="product_name" value="{{ $product->aladin_mall }}" />
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Tokopedia</label>
                            <input type="text" placeholder="https://www.tokopedia.com/" name="tokopedia" class="form-control" id="product_name" value="{{ $product->tokopedia }}"/>
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Shopee</label>
                            <input type="text" placeholder="https://www.shopee.com/" name="shopee" class="form-control" id="product_name" value="{{ $product->shopee }}"/>
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Lazada</label>
                            <input type="text" placeholder="https://www.lazada.com/" name="lazada" class="form-control" id="product_name" value="{{ $product->lazada }}"/>
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Blibli</label>
                            <input type="text" placeholder="https://www.blibli.com/" name="blibli" class="form-control" id="product_name" value="{{ $product->blibli }}"/>
                        </div>
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Bukalapak</label>
                            <input type="text" placeholder="https://www.bukalapak.com/" name="bukalapak" class="form-control" id="product_name" value="{{ $product->bukalapak }}"/>
                        </div>
                </div>
            </div>
            <!-- card end// -->
        </div>
        <div class="col-lg-3 float-start">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Media</h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <img id="image-product" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" />
                        <input id="input-product" class="form-control" name="img" type="file" />
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Images</h4>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <img id="image-product" width="1000" src="{{ url('assets/imgs/products') }}/{{ $product->img }}" alt="" />
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Organization</h4>
                </div>
                <div class="card-body">
                    <div class="row gx-2">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Brand</label>
                            <select class="form-select" name="brand">
                                <option>Select Brand...</option>
                                @foreach ($brand as $item)
                                <option value="{{ $item->id }}" @if($item->id == $product->brand) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option>Select Category...</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->id }}" @if($item->id == $product->category) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Exclusive</label>
                            <select class="form-select" name="exclusive">
                                <option>Select Exclusive...</option>
                                <option value="0" @if('0' == $product->brand) selected @endif>No Exclusive</option>
                                <option value="1" @if('1' == $product->brand) selected @endif>Best Sellers</option>
                                <option value="2" @if('2' == $product->brand) selected @endif>New Items</option>
                            </select>
                        </div>
                    </div>
                    <!-- row.// -->
                </div>
            </div>
            <!-- card end// -->
        </div>
        </form>
        @else
        <form class="col-lg-12" action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">{{$title}}</h2>
                <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Publich</button>
                </div>
            </div>
        </div>    
        <div class="col-lg-6 float-start">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Basic</h4>
                </div>
                <div class="card-body">
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Banner title</label>
                            <input type="text" placeholder="Banner Name" name="title" class="form-control" id="title" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Link</label>
                            <input type="text" placeholder="https://emshop.id/" name="link" class="form-control" id="link" />
                        </div>
                </div>
            </div>
            <!-- card end// -->
        </div>
        <div class="col-lg-3 float-start">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Media</h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <img id="banner-image" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" />
                        <input id="input-banner" class="form-control" name="img" type="file" />
                    </div>
                </div>
            </div>
            <!-- card end// -->
        </div>
        </form>
        @endif
    </div>
</section>
@endsection

@section('js')
@if ($slug == "product")
<script type="text/javascript">
		
    var rupiah = document.getElementById('rupiah_price');
    var rupiahDisc = document.getElementById('rupiah_disc_price');

    rupiah.addEventListener('keyup', function(e){
        rupiah.value = formatRupiah(this.value);
    });

    rupiahDisc.addEventListener('keyup', function(e){
        rupiahDisc.value = formatRupiah(this.value);
    });

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }

    window.addEventListener('load', function() {
        document.getElementById('input-product').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('image-product');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);
                }

                img.src = URL.createObjectURL(this.files[0]);
            }
        }); 
    });
</script>
@else
<script>
    window.addEventListener('load', function() {
        document.getElementById('input-banner').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('banner-image');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url
            }
        });
    });
</script>
@endif


@endsection
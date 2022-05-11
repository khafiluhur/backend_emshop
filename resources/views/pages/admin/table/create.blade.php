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
        @if($slug == 'product')
        <form class="col-lg-12" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="">
            <div class="content-header">
                <h3 class="content-title">{{$title}}</h3>
            </div>
        </div>
        <div class="">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Upload Produk</h4>
                </div>
                <div class="card-body row">
                    <div class="col-4">
                        <p class="fw-bolder">Foto Produk <span class="badge bg-light">Wajib</span></p>
                        <p>Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran minimum 700 x 700 px).</p>
                        <p>Pilih foto produk atau tarik dan letakkan hingga 5 foto sekaligus di sini. Cantumkan min. 3 foto yang menarik agar produk semakin menarik pembeli.</p>
                    </div>
                    <div class="col-8">
                        {{-- <img id="image-product" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" /> --}}
                        <input id="input-product" class="form-control" name="img" type="file" />
                    </div>
                </div>
            </div>

            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Informasi Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row gx-2">
                        <div class="row mb-5">
                            <div class="col-4">
                                <p class="fw-bolder">Nama Produk <span class="badge bg-light">Wajib</span></p>
                                <p>Cantumkan min. 40 karakter agar semakin menarik dan mudah ditemukan oleh pembeli, terdiri dari jenis produk, merek, dan keterangan seperti warna, bahan, atau tipe.</p>
                            </div>
                            <div class="col-8">
                                <input type="text" placeholder="Contoh: Sepatu Pria (Jenis/Kategori Produk) + Tokostore (Merek) + Kanvas Hitam (Keterangan)" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" name="name" onchange="checkValue()" id="product_name" />
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="fw-bolder">Kategori <span class="badge bg-light">Wajib</span></p>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="category">
                                    <option>Pilih Kategori</option>
                                    @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <p class="fw-bolder">Merek <span class="badge bg-light">Wajib</span></p>
                                <p>Tambah keterangan secara rinci supaya produkmu makin mudah dikenali pembeli.</p>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="brand">
                                    <option>Pilih Merek</option>
                                    @foreach ($brand as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <p class="fw-bolder">Merek <span class="badge bg-light">Wajib</span></p>
                                <p>Tambah keterangan secara rinci supaya produkmu makin mudah dikenali pembeli.</p>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="exclusive">
                                    <option>Pilih Exclusive...</option>
                                    <option value="0">No Exclusive</option>
                                    <option value="1">Best Sellers</option>
                                    <option value="2">New Items</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- row.// -->
                </div>
            </div>
            <!-- card end// -->
        </div>    
        <div class="">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Detail Produk</h4>
                </div>
                <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4">
                                <p class="fw-bolder">Desktipsi Produk <span class="badge bg-light">Wajib</span></p>
                                <p>Pastikan deskripsi produk memuat spesifikasi, ukuran, bahan, masa berlaku, dan lainnya. Semakin detail, semakin berguna bagi pembeli, cantumkan min. 260 karakter agar pembeli semakin mudah mengerti dan menemukan produk anda</p>
                            </div>
                            <div class="col-8">
                                <textarea class="form-control" name="short_desc" rows="13" placeholder="Sepatu Sneakers Pria Tokostore Kanvas Hitam Seri C28B
                                
- Model simple
- Nyaman Digunakan
- Tersedia warna hitam
- Sole PVC (injection shoes) yang nyaman dan awet untuk digunakan sehari - hari
                                
Bahan:
Upper: Semi Leather (kulit tidak pecah-pecah)
Sole: Premium Rubber Sole
                                
Ukuran
39 : 25,5 cm
40 : 26 cm
41 : 26.5 cm
42 : 27 cm
43 : 27.5 - 28 cm
                                
Edisi terbatas dari Tokostore dengan model baru dan trendy untukmu. Didesain untuk bisa dipakai dalam berbagai acara. Sangat nyaman saat dipakai sehingga dapat menunjang penampilan dan kepercayaan dirimu. Beli sekarang sebelum kehabisan!"></textarea>
                            </div>
                        </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Pengelolaan Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Status Produk</p>
                            <p>Jika status aktif, produkmu dapat dicari oleh calon pembeli.</p>
                        </div>
                        <div class="col-8">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked disabled>
                                <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">SKU (Stock Keeping Unit) <span class="badge bg-light">Wajib</span></p>
                            <p>Gunakan kode unik SKU jika kamu ingin menandai produkmu.</p>
                        </div>
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <input type="number" placeholder="SKU" class="form-control" name="sku" id="sku" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Harga</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Harga Satuan <span class="badge bg-light">Wajib</span></p>
                        </div>
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input placeholder="Masukkan Harga" type="text" name="price" class="form-control" id="rupiah_price" aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Harga Diskon <span class="badge bg-light">Wajib</span></p>
                        </div>
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input placeholder="Masukkan Harga" type="text" name="disc_price" class="form-control" id="rupiah_disc_price" aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Diskon <span class="badge bg-light">Wajib</span></p>
                        </div>
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <input placeholder="Masukkan Harga" type="text" name="disc" class="form-control" id="rupiah_disc_price" aria-describedby="basic-addon1"/>
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Link Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Aladin Mall </p>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="Masukkan Link Produk Aladin Mall" name="aladin_mall" class="form-control" id="product_name" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Tokopedia </p>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="Masukkan Link Produk Tokopedia" name="tokopedia" class="form-control" id="product_name" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Shopee </p>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="Masukkan Link Produk Shopee" name="shopee" class="form-control" id="product_name" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Lazada </p>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="Masukkan Link Produk Lazada" name="lazada" class="form-control" id="product_name" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Blibli </p>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="Masukkan Link Produk Blibli" name="blibli" class="form-control" id="product_name" />
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="fw-bolder">Bukalapak </p>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="Masukkan Link Produk Bukalapak" name="bukalapak" class="form-control" id="product_name" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end// -->
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


    function checkValue(){
        if(document.getElementById("product_name").value.length > 0){
            console.log('add');
            document.getElementById("myDiv").classList.remove("form-group");
            // document.getElementById("myDiv").classList.add("form-group");
        } else {
            console.log('remove');
            // document.getElementById("myDiv").classList.remove("form-group");
        }
    }
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
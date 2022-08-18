@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">{{$title}}</h2>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-md-12 col-12 me-auto mb-md-0 mb-3">
                    <select class="form-select" id="select-product">
                        <option value="all-product" selected>All product</option>
                        @foreach ($items as $item)
                            <option value="{{$item->slug}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </header>
        <div class="card-body">
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-8 flex-grow-1 col-name text-center">
                        <div class="info w-100">
                            <h6 class="mb-0">Aladin Mall</h6>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-4 col-price text-center"><span id="aladin">0</span> Klik</div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-8 flex-grow-1 col-name text-center">
                        <div class="info w-100">
                            <h6 class="mb-0">Tokopedia</h6>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-4 col-price text-center"><span id="tokopedia">0</span> Klik</div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-8 flex-grow-1 col-name text-center">
                        <div class="info w-100">
                            <h6 class="mb-0">Shopee</h6>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-4 col-price text-center"><span id="shopee">0</span> Klik</div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-8 flex-grow-1 col-name text-center">
                        <div class="info w-100">
                            <h6 class="mb-0">Lazada</h6>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-4 col-price text-center"><span id="lazada">0</span> Klik</div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-8 flex-grow-1 col-name text-center">
                        <div class="info w-100">
                            <h6 class="mb-0">Blibli</h6>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-4 col-price text-center"><span id="blibli">0</span> Klik</div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-8 flex-grow-1 col-name text-center">
                        <div class="info w-100">
                            <h6 class="mb-0">Bukalpak</h6>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-4 col-price text-center"><span id="bukalapak">0</span> Klik</div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
        </div>
    </div>
    <!-- card end// -->
</section>
<!-- content-main end// -->
@endsection

@section('js')
<script>
    $('#select-product').on('change', function() {
        var site = "{{url('')}}"
        var url = site+"/api/product/view/"+this.value
        var request = new XMLHttpRequest()

        request.open('GET', url, true)
        request.setRequestHeader("Authorization", "Bearer 1|3mTRZGnfTJ4wB0iX7LbAQbEKo6ZtQIbB56zxbNpA")
        request.onload = function () {
        // Begin accessing JSON data here
        var data = JSON.parse(this.response)
        if (request.status >= 200 && request.status < 400) {
            if(data.data.data != null) {
                document.getElementById("aladin").textContent=data.data.data['aladin_mall'];
                document.getElementById("tokopedia").textContent=data.data.data['tokopedia'];
                document.getElementById("shopee").textContent=data.data.data['shopee'];
                document.getElementById("lazada").textContent=data.data.data['lazada'];
                document.getElementById("blibli").textContent=data.data.data['blibli'];
                document.getElementById("bukalapak").textContent=data.data.data['bukalapak'];
            } else {
                document.getElementById("aladin").textContent=0;
                document.getElementById("tokopedia").textContent=0;
                document.getElementById("shopee").textContent=0;
                document.getElementById("lazada").textContent=0;
                document.getElementById("blibli").textContent=0;
                document.getElementById("bukalapak").textContent=0;
            }
        } else {
            console.log('error')
        }
        }

        request.send()
    });
</script>
<script src="assets/js/vendors/chart.js"></script>
<script src="assets/js/custom-chart.js" type="text/javascript"></script>
@endsection
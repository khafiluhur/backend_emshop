@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="row">
        <form class="col-lg-12" action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="product_name" class="form-label">Brand title</label>
                                <input type="text" placeholder="Brand Name" name="name" class="form-control" id="title" />
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
                        <div class="input-upload">
                            <img id="brand-image" src="{{url('assets/imgs/theme/upload.svg')}}" alt="" />
                            <input class="form-control" name="img" type="file" />
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
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category">
                                    <option>Select Category...</option>
                                    @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- row.// -->
                    </div>
                </div>
                <!-- card end// -->
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    window.addEventListener('load', function() {
        document.querySelector('input[type="file"]').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('brand-image');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);  // no longer needed, free memory
                }

                img.src = URL.createObjectURL(this.files[0]); // set src to blob url
            }
        });
    });
</script>
@endsection
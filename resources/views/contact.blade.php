@extends('layouts.home')
@section('page-header')
<div class="container shape-container d-flex align-items-center py-lg">
    <div class="col px-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <img src="{{ url('logo/logowhite.svg') }}" alt="Logo kelasbisa" height="100" width="auto" class="mb-3">
                <h1 class="text-white display-1">Hubungi Kami</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="section features-1">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h3 class="display-3">Hubungi Kami</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <p class="lead">Jika ada pertanyaan, kritik, saran, atau keluhan, jangan sungkan hubungi kami di alamat
                    email kami</p>
                <p><b>admin@kelasbisa.my.id</b></p>
            </div>
        </div>
    </div>
</div>
@endsection

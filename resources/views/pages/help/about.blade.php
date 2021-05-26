@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="fas fa-paw"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">Curatorial EGE100</span>
            <span class="info-box-text">Centralized system for productivity improvement of the EGE100 project curators.</span>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="fab fa-laravel"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">Laravel 8</span>
            <span class="info-box-text">Internally, curatorial is built with Laravel. This is a modern PHP framework based on MVC pattern.</span>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="info-box shadow">
        <span class="info-box-icon bg-primary"><i class="fas fa-smile"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">Developer</span>
            <span class="info-box-text">My name is Maksim Vlasov and I am the one who developed the whole service you are currently using.</span>
        </div>
    </div>
</div>
@endsection

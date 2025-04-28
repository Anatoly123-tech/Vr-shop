@extends('layouts.layout')

@section('content')
<div class="container mt-5 mb-5">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">О компании VR-Shop</h1>
        <p class="lead text-muted">Добро пожаловать в VR-Shop, ведущий интернет-магазин, специализирующийся на продаже виртуальных реальностей и аксессуаров для них.</p>
    </div>

    <!-- Mission Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h3 class="fw-semibold text-primary">Наша миссия</h3>
                    <p class="text-dark">Наша цель — предоставить клиентам самые современные и высококачественные устройства виртуальной реальности. Мы стремимся улучшить опыт пользователей, предлагая только лучшие продукты для полного погружения в виртуальные миры.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Offerings Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h3 class="fw-semibold text-primary">Что мы предлагаем</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0">Шлемы виртуальной реальности</li>
                        <li class="list-group-item border-0">Аксессуары для VR</li>
                        <li class="list-group-item border-0">Компьютеры для лучшего использования VR</li>
                        <li class="list-group-item border-0">Поддержку и сервис для наших клиентов</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h3 class="fw-semibold text-primary">Наши ценности</h3>
                    <p class="text-dark">Мы ценим качество, инновации и удовлетворенность наших клиентов. Мы стремимся быть надежным партнером и источником вдохновения для всех любителей технологий.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styles for enhanced appearance */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .list-group-item {
        padding: 0.5rem 0;
        background-color: transparent;
    }
    .text-primary {
        color: #007bff !important;
    }
</style>
@endsection

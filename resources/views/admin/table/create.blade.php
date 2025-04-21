@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Добавить товар</h1>
        <form action="{{ route('admin.table.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="title">Название</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group mb-3">
                <label for="content">Описание</label>
                <textarea id="content" name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Категория</label>
                <input type="number" id="category_id" name="category_id" class="form-control" value="{{ old('category_id') }}" required>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="status_id">Статус</label>
                <input type="number" id="status_id" name="status_id" class="form-control" value="{{ old('status_id') }}" required>
                @error('status_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="price">Цена</label>
                <input type="number" id="price" name="price" class="form-control" step="0" value="{{ old('price') }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="old_price">Старая цена (если есть)</label>
                <input type="number" id="old_price" name="old_price" class="form-control" step="0" value="{{ old('old_price') }}">
                @error('old_price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="img">Изображение</label>
                <input type="file" id="img" name="img" class="form-control">
                @error('img')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.table.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection

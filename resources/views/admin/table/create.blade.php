@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Добавить товар</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.table.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="title">Название</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"
                    required>
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
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <select id="status_id" name="status_id" class="form-control" required>
                    <option value="">Выберите статус</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                            {{ $status->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="price">Цена</label>
                <input type="number" id="price" name="price" class="form-control" step="1"
                    value="{{ old('price') }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="old_price">Старая цена (если есть)</label>
                <input type="number" id="old_price" name="old_price" class="form-control" step="1"
                    value="{{ old('old_price') }}">
                @error('old_price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="img">Главное изображение</label>
                <input type="file" class="form-control" name="img">
                @error('img')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="additional_images">Дополнительные изображения (до 3)</label>
                <input type="file" class="form-control" name="additional_images[]" multiple>
                @error('additional_images.*')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                
                <button type="submit" class="btn btn-success">Сохранить</button>
                <a href="{{ route('admin.table.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection

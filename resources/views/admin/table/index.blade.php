@extends('layouts.admin')

@section('content')
<h1>Таблица товаров</h1>
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.table.create') }}" class="btn btn-success">Добавить товар</a>
        <button class="btn btn-danger" id="deleteSelected">Удалить выбранные</button>
    </div>
    <form method="GET" action="{{ route('admin.table.index') }}" id="filter-form" class="d-flex align-items-center">
        <div class="input-group me-2" style="width: 250px;">
            <input type="text" name="title" id="title" class="form-control" placeholder="Поиск товара" value="{{ $filters['title'] ?? '' }}">
            <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
        </div>
        <select name="sort" id="sort" class="form-control me-2" style="width: 200px;">
            <option value="created_at_desc" {{ ($filters['sort'] ?? 'created_at_desc') == 'created_at_desc' ? 'selected' : '' }}>По умолчанию</option>
            <option value="title_asc" {{ ($filters['sort'] ?? '') == 'title_asc' ? 'selected' : '' }}>Название (А-Я)</option>
            <option value="title_desc" {{ ($filters['sort'] ?? '') == 'title_desc' ? 'selected' : '' }}>Название (Я-А)</option>
            <option value="price_asc" {{ ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' }}>Цена (по возрастанию)</option>
            <option value="price_desc" {{ ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' }}>Цена (по убыванию)</option>
            <option value="category_asc" {{ ($filters['sort'] ?? '') == 'category_asc' ? 'selected' : '' }}>Категория (А-Я)</option>
            <option value="category_desc" {{ ($filters['sort'] ?? '') == 'category_desc' ? 'selected' : '' }}>Категория (Я-А)</option>
            <option value="status_asc" {{ ($filters['sort'] ?? '') == 'status_asc' ? 'selected' : '' }}>Статус (А-Я)</option>
            <option value="status_desc" {{ ($filters['sort'] ?? '') == 'status_desc' ? 'selected' : '' }}>Статус (Я-А)</option>
        </select>
        <button type="submit" class="btn btn-success me-2">Применить</button>
        <a href="{{ route('admin.table.index') }}" class="btn btn-secondary">Сбросить</a>
    </form>
</div>
<form action="{{ route('admin.table.delete') }}" method="POST" id="deleteForm" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="deleteIds">
</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">
                <input type="checkbox" id="checkAll">
            </th>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col" class="col-2">Описание</th>
            <th scope="col">Категории</th>
            <th scope="col">Статус</th>
            <th scope="col">Фото</th>
            <th scope="col">Доп. фото</th>
            <th scope="col">Цена</th>
            <th scope="col">Старая цена</th>
            <th scope="col">Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <form action="{{ route('admin.table.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <tr>
                    <td>
                        <input type="checkbox" class="product-checkbox" value="{{ $product->id }}">
                    </td>
                    <th scope="row">{{ $product->id }}</th>
                    <td>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}">
                    </td>
                    <td>
                        <textarea class="form-control" name="content" rows="5">{{ old('content', $product->content) }}</textarea>
                    </td>
                    <td>
                        <select class="form-control" name="category_id" required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <select class="form-control" name="status_id" required>
                            <option value="status_id">Выберите статус</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id', $product->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->title }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        @if ($product->img)
                            <img src="{{ asset('assets/front/img/' . $product->img) }}" style="width: 100px; height: auto;">
                        @else
                            <p>Изображение не установлено.</p>
                        @endif
                        <br>
                        <input type="file" class="form-control" name="img">
                    </td>
                    <td>
                        @if ($product->images->count())
                            @foreach ($product->images as $image)
                                <img src="{{ asset('assets/front/img/' . $image->path) }}" style="width: 50px; height: auto; margin-right: 5px;">
                            @endforeach
                        @else
                            <p>Доп. изображения отсутствуют.</p>
                        @endif
                        <br>
                        <input type="file" class="form-control" name="additional_images[]" multiple>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="old_price" value="{{ old('old_price', $product->old_price) }}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-warning btn-sm">Сохранить</button>
                    </td>
                </tr>
            </form>
        @endforeach
    </tbody>
</table>

<script>
    document.getElementById('checkAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.getElementById('deleteSelected').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(checkbox =>
            checkbox.value);
        if (selectedIds.length > 0) {
            if (confirm('Вы действительно хотите удалить выбранные товары?')) {
                document.getElementById('deleteIds').value = JSON.stringify(selectedIds);
                document.getElementById('deleteForm').submit();
            }
        } else {
            alert('Выберите хотя бы один товар для удаления.');
        }
    });
</script>

<div class="col-md-12">
    <nav aria-label="Page navigation example">
        {{ $products->links('pagination.custom') }}
    </nav>
</div>
@endsection

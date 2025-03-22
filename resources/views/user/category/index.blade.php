@extends('layouts.master')

@section('title', $category->name)
@section('content')
    <div class="container-fluid mt-4">
        <!-- Ảnh danh mục cha -->
        @if ($category->image)
            <div class="category-header-container">
                <img class="category-header" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                <div class="category-header-overlay">{{ $category->name }}</div>
            </div>
        @endif


        <h2 class="mt-3">{{ $category->name }}</h2>

        <!-- Hiển thị danh mục con -->
        @if ($subcategories->count() > 0)
            <h3 class="mt-3">Danh mục con:</h3>
            <div class="row">
                @foreach ($subcategories as $subcategory)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="category-card">
                            <a href="{{ route('category.show', $subcategory->slug) }}" class="text-decoration-none">
                                <img class="category-img" src="{{ asset('storage/' . $subcategory->image) }}"
                                    alt="{{ $subcategory->name }}">
                                <div class="category-title">{{ $subcategory->name }}</div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- @if ($lessons->count() > 0)
        <h3>Bài học:</h3>
        <ul>
            @foreach ($lessons as $lesson)
                <li>{{ $lesson->title }}</li>
            @endforeach
        </ul>
    @endif --}}
    </div>

    <style>
        /* Ảnh danh mục cha */
        .category-header {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Hiển thị tên danh mục trên ảnh */
        .category-header-container {
            position: relative;
            text-align: center;
            color: white;
        }

        .category-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Mờ nền */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 10px;
        }

        .category-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .category-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .category-title {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }
    </style>
@endsection

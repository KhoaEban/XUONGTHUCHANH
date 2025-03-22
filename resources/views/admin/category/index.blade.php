@extends('layouts.master_admin')

@section('title', 'Quản lý Danh Mục')

@section('content')
    <div class="container-fluid">
        <!-- Nút tạo danh mục -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.category.create') }}" class=""
                style="border: none; background-color: #2185D0; color: white; padding: 10px; font-size: 16px; font-weight: bold;">Tạo
                danh mục</a>
        </div>

        <div class="d-flex justify-content-between">
            <h2 class="">Danh sách Danh Mục</h2>
            <div>
                <form action="" method="">
                    <select class="d-inline w-auto"
                        style="border: none; border: 1px solid #6C757D; color: #000000; padding: 7px; font-size: 14px;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit"
                        style="border: none; background-color: #6C757D; color: white; padding: 7px; font-size: 14px;">
                        Apply
                    </button>
                </form>
            </div>
        </div>

        <!-- Bảng danh sách danh mục -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Hình ảnh</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if ($category->image)
                                        <img class="img-fluid" width="100"
                                            src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                    @else
                                        Không có ảnh
                                    @endif
                                </td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td>{{ $category->updated_at->format('d/m/Y') }}</td>
                                <td>
                                    <!-- Kiểm tra nếu có danh mục con thì hiển thị button -->
                                    @if ($category->children->count() > 0)
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admin.category.create.child', ['parent_id' => $category->id]) }}">
                                            Thêm danh mục con
                                        </a>
                                        <button class="btn btn-info btn-sm view-children" data-id="{{ $category->id }}">
                                            Xem danh mục con
                                        </button>
                                    @else
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admin.category.create.child', ['parent_id' => $category->id]) }}">
                                            Thêm danh mục con
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.category.edit', $category->id) }}"
                                        class="btn btn-sm btn-primary">Sửa</a>
                                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-end">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hiển thị danh mục con -->
    <div class="modal fade" id="childrenModal" tabindex="-1" aria-labelledby="childrenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="childrenModalLabel">Danh mục con</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="childrenList" class="list-group">
                        <!-- Danh mục con sẽ hiển thị ở đây -->

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.view-children').forEach(button => {
                button.addEventListener('click', function() {
                    let categoryId = this.getAttribute('data-id');
                    loadChildren(categoryId, 0);
                });
            });

            function loadChildren(categoryId, level = 0, parentElement = null) {
                fetch(`/admin/category/children/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        let childrenList;

                        // Nếu là danh mục cấp đầu tiên, dùng danh sách chính
                        if (level === 0) {
                            childrenList = document.getElementById('childrenList');
                            childrenList.innerHTML = ''; // Xóa danh sách cũ
                        } else {
                            // Nếu là danh mục con, kiểm tra xem đã có danh sách con chưa
                            let existingList = parentElement.querySelector('ul.nested-category');
                            if (!existingList) {
                                childrenList = document.createElement('ul');
                                childrenList.classList.add('nested-category');
                                parentElement.appendChild(childrenList);
                            } else {
                                childrenList = existingList;
                            }
                        }

                        if (data.length === 0 && level === 0) {
                            childrenList.innerHTML = '<li class="list-group-item">Không có danh mục con</li>';
                        } else {
                            data.forEach(child => {
                                let listItem = document.createElement('li');
                                listItem.classList.add('list-group-item');
                                listItem.innerHTML = `
                                    <span style="margin-left: ${level * 15}px;">${level > 0 ? '-- ' : ''}${child.name}</span>
                                    <div class="d-flex justify-content-end mt-2">
                                        <a href="/admin/category/edit/${child.id}" class="btn btn-warning btn-sm me-2">Sửa</a>
                                        <button class="btn btn-danger btn-sm delete-child" data-id="${child.id}">Loại bỏ danh mục</button>
                                    </div>`;
                                childrenList.appendChild(listItem);

                                // Nếu danh mục có con, tiếp tục đệ quy để lấy danh mục con bên trong
                                if (child.has_children) {
                                    loadChildren(child.id, level + 1, listItem);
                                }
                            });
                        }

                        // Hiển thị modal nếu là cấp đầu tiên
                        if (level === 0) {
                            let modal = new bootstrap.Modal(document.getElementById('childrenModal'));
                            modal.show();
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            }

            // Xử lý xóa danh mục con
            document.addEventListener('click', function(event) {
                let button = event.target.closest('.delete-child');
                if (button) {
                    let childId = button.getAttribute('data-id');
                    if (childId) {
                        deleteCategory(childId, button);
                    } else {
                        console.error("Không tìm thấy data-id của danh mục con");
                    }
                }
            });
        });

        // Hàm xóa danh mục con
        function deleteCategory(categoryId, button) {
            if (!confirm("Bạn có chắc chắn muốn loại bỏ danh mục này khỏi danh mục cha?")) return;

            fetch(`/admin/category/unlink/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Danh mục con đã được loại bỏ khỏi danh mục cha!");
                        button.closest('li').remove(); // Xóa phần tử khỏi danh sách hiển thị
                    } else {
                        alert("Lỗi khi loại bỏ danh mục con!");
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }
    </script>

    <style>
        .nested-category {
            list-style-type: none;
            padding-left: 20px;
            margin-top: 5px;
        }

        .nested-category .list-group-item {
            border-left: 2px solid #2185D0;
            padding-left: 10px;
            margin-top: 3px;
        }
    </style>
@endsection

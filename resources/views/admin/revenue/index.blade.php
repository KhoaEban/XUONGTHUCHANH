@extends('layouts.master_admin')

<style>
    .custom-card {
        border-radius: 10px;
        /* Bo tròn các góc của thẻ card */
        background-color: #f8f9fa;
        /* Màu nền nhẹ cho card */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Đổ bóng nhẹ cho card */
        padding: 20px;
        /* Thêm khoảng cách bên trong cho card */
        margin-bottom: 20px;
        /* Khoảng cách dưới card */
    }

    .custom-card-body {
        padding: 20px;
        /* Thêm khoảng cách bên trong cho card body */
    }

    .custom-form {
        display: flex;
        flex-direction: column;
        /* Sắp xếp các phần tử theo cột */
    }

    .custom-form-group {
        margin-bottom: 15px;
        /* Khoảng cách giữa các nhóm form */
    }

    .custom-form-label {
        font-size: 1rem;
        /* Kích thước chữ cho label */
        color: #495057;
        /* Màu chữ cho label */
        margin-bottom: 5px;
        /* Khoảng cách dưới label */
    }

    .custom-form-control {
        width: 100%;
        border: 1px solid #ced4da;
        /* Đường viền cho input */
        border-radius: 5px;
        /* Bo tròn các góc của input */
        padding: 10px;
        /* Thêm khoảng cách bên trong cho input */
        font-size: 1rem;
        /* Kích thước chữ cho input */
        transition: border-color 0.3s;
        /* Hiệu ứng chuyển tiếp cho border */
    }

    .custom-form-control:focus {
        border-color: #007bff;
        /* Màu border khi input được chọn */
        outline: none;
        /* Bỏ viền ngoài khi input được chọn */
    }

    .custom-btn {
        /* Bo tròn các góc của nút */
        padding: 10px 15px;
        /* Thêm khoảng cách bên trong cho nút */
        font-size: 1rem;
        /* Kích thước chữ cho nút */
        text-decoration: none;
        /* Bỏ gạch chân cho nút */
        display: inline-block;
        /* Để nút có thể có padding */
        cursor: pointer;
        /* Hiển thị con trỏ khi hover */
        border: none;
        /* Bỏ đường viền cho nút */
    }

    .custom-btn-primary {
        background-color: #006699;
        /* Màu nền cho nút chính */
        color: white;
        /* Màu chữ cho nút chính */
    }

    .custom-btn-primary:hover {
        background-color: #0056b3;
        /* Màu nền khi hover */
    }

    .custom-btn-secondary {
        background-color: transparent;
        /* Màu nền cho nút phụ */
        color: #6c757d;
        /* Màu chữ cho nút phụ */
        border: 1px solid #6c757d;
        /* Đường viền cho nút phụ */
    }

    .custom-btn-secondary:hover {
        background-color: #6c757d;
        /* Màu nền khi hover cho nút phụ */
        color: white;
        /* Màu chữ khi hover cho nút phụ */
    }

    .custom-text-muted {
        font-size: 0.9rem;
        /* Kích thước chữ cho văn bản nhạt */
        color: #6c757d;
        /* Màu chữ nhạt */
        margin-top: 10px;
        /* Khoảng cách trên văn bản nhạt */
    }
</style>

@section('title', 'Thống kê doanh thu')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="fw-bold mb-0">Thống kê doanh thu</h2>
                        <p class="text-muted">Theo dõi và phân tích doanh thu theo thời gian</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng quan doanh thu -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Tổng số giao dịch</h6>
                        <h3 class="fw-bold mb-0">{{ $totalPayments ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Giao dịch thành công</h6>
                        <h3 class="fw-bold text-success mb-0">{{ $successfulPayments ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Giao dịch thất bại</h6>
                        <h3 class="fw-bold text-danger mb-0">{{ $failedPayments ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Tổng doanh thu</h6>
                        <h3 class="fw-bold text-primary mb-0">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} VNĐ</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form lọc -->
        <div class="custom-card">
            <div class="custom-card-body">
                <form method="GET" action="{{ route('revenue.index') }}" class="custom-form">
                    <div class="row">
                        <div class="col-6">
                            <div class="custom-form-group">
                                <label class="custom-form-label">Từ ngày</label>
                                <input type="date" name="start_date" id="start_date" class="custom-form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="custom-form-group">
                                <label class="custom-form-label">Đến ngày</label>
                                <input type="date" name="end_date" id="end_date" class="custom-form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="custom-form-actions">
                        <button type="submit" class="custom-btn custom-btn-primary">Lọc dữ liệu</button>
                        <a href="{{ route('revenue.index') }}" class="custom-btn custom-btn-secondary">Xóa bộ lọc</a>
                    </div>
                </form>
                @if (request('start_date') && request('end_date'))
                    <p class="custom-text-muted">Hiển thị dữ liệu từ
                        <strong>{{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}</strong> đến
                        <strong>{{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}</strong>
                    </p>
                @else
                    <p class="custom-text-muted">Hiển thị dữ liệu tháng này
                        <strong>{{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }}</strong> -
                        <strong>{{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <!-- Biểu đồ doanh thu theo ngày -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-semibold mb-0">Doanh thu theo ngày</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <canvas id="revenueChart" width="100" height="25"></canvas>
                    </div>
                    <div class="col-2">
                        <canvas id="revenueChartCircle" width="100" height="25"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết giao dịch -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-semibold mb-0">Chi tiết giao dịch</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3">#</th>
                                <th class="py-3">Người dùng</th>
                                <th class="py-3">Khóa học</th>
                                <th class="py-3">Số tiền</th>
                                <th class="py-3">Phương thức</th>
                                <th class="py-3">Trạng thái</th>
                                <th class="py-3">Ngày thanh toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $key => $payment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->course->title ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>
                                        @php
                                            $statusLabels = [
                                                'completed' => ['label' => 'Thành công', 'class' => 'bg-success'],
                                                'pending' => ['label' => 'Đang chờ', 'class' => 'bg-warning'],
                                                'failed' => ['label' => 'Thất bại', 'class' => 'bg-danger'],
                                            ];
                                            $status = $statusLabels[$payment->status] ?? [
                                                'label' => 'Không xác định',
                                                'class' => 'bg-secondary',
                                            ];
                                        @endphp
                                        <span
                                            class="badge {{ $status['class'] }} text-white">{{ $status['label'] }}</span>
                                    </td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-center">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Dữ liệu từ PHP
        const revenueData = @json($revenueByDay);
        const labels = revenueData.map(item => {
            return new Date(item.transaction_date).toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        });
        const data = revenueData.map(item => item.daily_revenue);

        // Vẽ biểu đồ
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: data,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#007bff',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN');
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Ngày'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y.toLocaleString('vi-VN') + ' VNĐ';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const ctxCircle = document.getElementById('revenueChartCircle').getContext('2d');

        // Dữ liệu từ PHP
        const totalRevenue = {{ $totalRevenue ?? 0 }};
        const successfulPayments = {{ $successfulPayments ?? 0 }};
        const failedPayments = {{ $failedPayments ?? 0 }};

        // Vẽ biểu đồ tròn
        new Chart(ctxCircle, {
            type: 'doughnut',
            data: {
                labels: ['Thành công', 'Thất bại'],
                datasets: [{
                    data: [successfulPayments, failedPayments],
                    backgroundColor: ['#339966', '#CC6666'],
                    hoverOffset: 4
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toLocaleString('vi-VN');
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

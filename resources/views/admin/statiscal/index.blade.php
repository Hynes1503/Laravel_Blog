@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mt-5">
        <!-- Tổng thời gian xem -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tổng thời gian xem tất cả blog: {{ number_format($totalViewTime) }} giây
                </h2>
            </div>
        </div>

        <!-- Biểu đồ View Time theo Danh mục -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('View time  theo danh mục') }}
                </h2>
                <canvas id="categoryChart" height="100"></canvas>
            </div>
        </div>

        <!-- Biểu đồ Top 10 Blog -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Top 10 Blog có view cao nhất') }}
                </h2>
                <canvas id="topBlogsChart" height="100"></canvas>
            </div>
        </div>

        <!-- Điểm chung -->
        <div class="card">
            <div class="card-body">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">Điểm chung của các Blog có View Time cao</h3>
                <ul>
                    <li>- Độ dài tiêu đề trung bình: {{ $commonTraits['avg_title_length'] }} ký tự</li>
                    <li>- Các danh mục phổ biến:
                        <ul>
                            @foreach ($commonTraits['popular_categories'] as $catId => $count)
                                <li class="ml-4">+ {{ \App\Models\Category::find($catId)->name ?? 'Không xác định' }}: {{ $count }} blog</li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Thêm Chart.js từ CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Biểu đồ View Time theo Danh mục (Line Chart)
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'line', // Sử dụng biểu đồ đường
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        label: 'Tổng View Time (giây)',
                        data: @json($categoryData),
                        fill: false,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Thời gian xem (giây)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Danh mục'
                            }
                        }
                    }
                }
            });

            // Biểu đồ Top 10 Blog (Line Chart)
            const topBlogsCtx = document.getElementById('topBlogsChart').getContext('2d');
            new Chart(topBlogsCtx, {
                type: 'line', // Sử dụng biểu đồ đường
                data: {
                    labels: @json($topBlogTitles),
                    datasets: [{
                        label: 'View Time (giây)',
                        data: @json($topBlogViewTimes),
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Thời gian xem (giây)'
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45, // Xoay nhãn nếu quá dài
                                autoSkip: true
                            },
                            title: {
                                display: true,
                                text: 'Tiêu đề Blog'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
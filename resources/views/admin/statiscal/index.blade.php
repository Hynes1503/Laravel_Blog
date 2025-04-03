@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Statistical') }}
                </h2>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mt-5">

        <div class="card mb-4">
            <div class="card-body flex justify-center gap-4">
                <a href="{{ route('admin.user.index') }}" class="block flex-1 max-w-xs">
                    <div class="card shadow-lg rounded-lg overflow-hidden w-full h-full border-1 border-black"
                        style="background-image: url('{{ asset('image/User_Icon.png') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full flex items-center justify-center">
                            <h5 class="card-title text-xl font-semibold text-gray-800">
                                <i class="fa-solid fa-circle-user"></i> User
                            </h5>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.blog.index') }}" class="block flex-1 max-w-xs">
                    <div class="card shadow-lg rounded-lg overflow-hidden w-full h-full border-1 border-black"
                        style="background-image: url('{{ asset('image/Blog_Icon.png') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full flex items-center justify-center">
                            <h5 class="card-title text-xl font-semibold text-gray-800">
                                <i class="fa-solid fa-blog"></i> Blogs
                            </h5>
                        </div>
                    </div>
                </a>

                <a href="{{ route('categories.index') }}" class="block flex-1 max-w-xs">
                    <div class="card shadow-lg rounded-lg overflow-hidden w-full h-full border-1 border-black"
                        style="background-image: url('{{ asset('image/category_icon.png') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full flex items-center justify-center">
                            <h5 class="card-title text-xl font-semibold text-gray-800">
                                <i class="fa-solid fa-icons"></i> Categories
                            </h5>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.pages.index') }}" class="block flex-1 max-w-xs">
                    <div class="card shadow-lg rounded-lg overflow-hidden w-full h-full border-1 border-black"
                        style="background-image: url('{{ asset('image/page_icon.png') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full flex items-center justify-center">
                            <h5 class="card-title text-xl font-semibold text-gray-800">
                                <i class="fa-solid fa-file"></i> Pages
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tổng thời gian xem -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tổng thời gian xem tất cả blog: {{ number_format($totalViewTime) }} giây
                </h3>
            </div>
        </div>

        <!-- View Time theo Danh mục -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">View Time theo Danh mục</h3>
                <canvas id="categoryChart" width="300" height="400"></canvas>
            </div>
        </div>

        <!-- Top 10 Blog (kết hợp đường và cột) -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                    Top 10 Blog: View Time và Lượt Thích
                </h3>
                <canvas id="topBlogsChart" width="600" height="400"></canvas>
            </div>
        </div>

        <!-- Điểm chung -->
        <div class="card">
            <div class="card-body">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">Điểm chung của các Blog có View Time cao</h3>
                <ul>
                    <li class="ml-2">- Độ dài tiêu đề trung bình: {{ $commonTraits['avg_title_length'] }} ký tự</li>
                    <li class="ml-2">- Tỷ lệ blog có hình ảnh: {{ $commonTraits['has_image_percentage'] }}%</li>
                    <li class="ml-2">- Các danh mục phổ biến:
                        <ul>
                            @foreach ($commonTraits['popular_categories'] as $catId => $count)
                                <li class="ml-6">+ {{ \App\Models\Category::find($catId)->name ?? 'Không xác định' }}:
                                    {{ $count }}
                                    blog</li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
        // Biến toàn cục để lưu các biểu đồ
        const charts = {};

        document.addEventListener('DOMContentLoaded', function() {
            // Category Chart
            charts['categoryChart'] = new Chart(document.getElementById('categoryChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        label: 'View Time',
                        data: @json($categoryData),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Top Blogs Chart (Kết hợp đường và cột)
            charts['topBlogsChart'] = new Chart(document.getElementById('topBlogsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($topBlogTitles),
                    datasets: [{
                            type: 'line', // Biểu đồ đường cho View Time
                            label: 'View Time (giây)',
                            data: @json($topBlogViewTimes),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false,
                            tension: 0.1,
                            yAxisID: 'y-view-time'
                        },
                        {
                            type: 'bar', // Biểu đồ cột cho Likes
                            label: 'Số lượt Thích',
                            data: @json($topBlogLikes),
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'y-likes'
                        }
                    ]
                },
                options: {
                    scales: {
                        'y-view-time': {
                            type: 'linear',
                            position: 'left',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Thời gian xem (giây)'
                            }
                        },
                        'y-likes': {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Số lượt Thích'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
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

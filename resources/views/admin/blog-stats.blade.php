<!DOCTYPE html>
<html>
<head>
    <title>Thống kê Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Thống kê Xu hướng Người dùng Dựa trên View Time</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h3>Tổng thời gian xem tất cả blog</h3>
                <p>{{ number_format($totalViewTime) }} giây</p>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-body">
                <h3>View Time theo Danh mục</h3>
                <canvas id="categoryChart" height="100"></canvas>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-body">
                <h3>Top 10 Blog có View Time cao nhất</h3>
                <canvas id="topBlogsChart" height="100"></canvas>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <h3>Điểm chung của các Blog có View Time cao</h3>
                <ul>
                    <li>Độ dài tiêu đề trung bình: {{ $commonTraits['avg_title_length'] }} ký tự</li>
                    <li>Tỷ lệ blog có hình ảnh: {{ $commonTraits['has_image_percentage'] }}%</li>
                    <li>Các danh mục phổ biến:
                        <ul>
                            @foreach ($commonTraits['popular_categories'] as $catId => $count)
                                <li>{{ \App\Models\Category::find($catId)->name ?? 'Không xác định' }}: {{ $count }} blog</li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <script>

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: 'Tổng View Time (giây)',
                    data: @json($categoryData),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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


        const topBlogsCtx = document.getElementById('topBlogsChart').getContext('2d');
        new Chart(topBlogsCtx, {
            type: 'bar',
            data: {
                labels: @json($topBlogTitles),
                datasets: [{
                    label: 'View Time (giây)',
                    data: @json($topBlogViewTimes),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
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
    </script>
</body>
</html>
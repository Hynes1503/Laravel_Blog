<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class AdminBlogStatsController extends Controller
{
    public function index()
    {
        $totalViewTime = Blog::sum('view_time');
        $viewTimeByCategory = Blog::getViewTimeByCategory();
        $topBlogs = Blog::getTopViewTimeBlogs(10);
        $commonTraits = $this->analyzeCommonTraits($topBlogs);

        // Chuẩn bị dữ liệu cho biểu đồ
        $categoryLabels = $viewTimeByCategory->pluck('category.name')->toArray();
        $categoryData = $viewTimeByCategory->pluck('total_view_time')->toArray();

        $topBlogTitles = $topBlogs->pluck('title')->toArray();
        $topBlogViewTimes = $topBlogs->pluck('view_time')->toArray();

        return view('admin.blog-stats', compact(
            'totalViewTime',
            'viewTimeByCategory',
            'topBlogs',
            'commonTraits',
            'categoryLabels',
            'categoryData',
            'topBlogTitles',
            'topBlogViewTimes'
        ));
    }

    private function analyzeCommonTraits($blogs)
    {
        $traits = [
            'avg_title_length' => 0,
            'has_image_percentage' => 0,
            'popular_categories' => [],
        ];

        $titleLengths = 0;
        $hasImageCount = 0;
        $categoryCount = [];

        foreach ($blogs as $blog) {
            $titleLengths += strlen($blog->title);
            if (!empty($blog->banner_image)) {
                $hasImageCount++;
            }
            $categoryId = $blog->category_id;
            $categoryCount[$categoryId] = ($categoryCount[$categoryId] ?? 0) + 1;
        }

        $blogCount = count($blogs);
        if ($blogCount > 0) {
            $traits['avg_title_length'] = round($titleLengths / $blogCount);
            $traits['has_image_percentage'] = round(($hasImageCount / $blogCount) * 100, 2);
            arsort($categoryCount);
            $traits['popular_categories'] = array_slice($categoryCount, 0, 3, true);
        }

        return $traits;
    }
}

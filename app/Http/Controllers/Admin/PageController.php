<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about-us')->published()->firstOrFail();

        return view('footer.about', compact('page'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact-us')->published()->firstOrFail();

        return view('footer.contact', compact('page'));
    }

    public function privacy()
    {
        $page = Page::where('slug', 'privacy')->published()->firstOrFail();

        return view('footer.privacy', compact('page'));
    }


    public function index()
    {
        $pages = Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
        ]);

        $page->update([
            'content' => $validated['content'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }
}

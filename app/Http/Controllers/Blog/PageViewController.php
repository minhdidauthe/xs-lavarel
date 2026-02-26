<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageViewController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();
        $renderedContent = $page->getRenderedBody();

        return view('blog.page', compact('page', 'renderedContent'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Index', [
            'filters' => FacadeRequest::all('search', 'order'),
            'posts' => Post::filter(FacadeRequest::only('search', 'order'))
                ->paginate(10)
            ->withQueryString()
            ->through(fn ($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'published_at' => $post->created_at->format('d/m/Y'),
            ]),
        ]);
    }
}

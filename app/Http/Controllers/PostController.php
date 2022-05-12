<?php

namespace App\Http\Controllers;

use App\Actions\UpsertPostAction;
use App\DataTransferObjects\PostData;
use App\Http\Requests\UpsertPostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(
        private readonly UpsertPostAction $upsertPostAction,

    ){}
    public function index()
    {
        return Inertia::render('Posts/Index', [
            'filters' => FacadeRequest::all('search', 'order'),
            'posts' => Post::whereBelongsTo(Auth::user())
                ->filter(FacadeRequest::only('search', 'order'))
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

    public function show(Post $post): \Inertia\Response
    {
        abort_if($post->user_id !== Auth::id(), Response::HTTP_FORBIDDEN, 'YOU CANNOT SEE THIS POST');

        return Inertia::render('Posts/Show', [
            'post' => [
                'title' => $post->title,
                'description' => $post->description,

            ],
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Posts/Create');
    }

    public function store(UpsertPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->upsert($request, new Post());

        return Redirect::route('posts')->with('success', 'Posts created.');
    }

    private function upsert(UpsertPostRequest $request, Post $post): void
    {
        $postData = new PostData(...$request->validated());

        $this->upsertPostAction->execute($post, $postData);
    }
}

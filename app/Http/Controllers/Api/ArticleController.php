<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Services\LLMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $llmService;

    public function __construct(LLMService $llmService)
    {
        $this->llmService = $llmService;
    }

    public function index(Request $request)
    {
        $query = Article::query();

        // Role-based access: Admins see all, Authors see their own
        $user = $request->user();
        if ($user && $user->role && strtolower($user->role->name) === 'author') {
            $query->where('author_id', $user->id);
        }

        // Filters
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('published_at', [$request->date_from, $request->date_to]);
        }

        $articles = $query->with(['categories', 'author'])->paginate(10);
        return \App\Http\Resources\ArticleResource::collection($articles);
    }

    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = null;
        $data['summary'] = null;
        $data['author_id'] = $request->user()->id;

        $article = Article::create($data);
        if ($request->has('categories')) {
            $article->categories()->sync($request->categories);
        }
        // Dispatch async job to generate slug and summary
        GenerateSlugAndSummaryJob::dispatch($article->id);

        return response()->json($article, 201);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function update(ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->validated();

        if ($request->has('title')) {
            $data['slug'] = null;
        }

        if ($request->has('content')) {
            $data['summary'] = null;
        }

        $article->update($data);
        if ($request->has('categories')) {
            $article->categories()->sync($request->categories);
        }
        // Dispatch async job to generate slug and summary
        GenerateSlugAndSummaryJob::dispatch($article->id);

        return response()->json($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(null, 204);
    }
}
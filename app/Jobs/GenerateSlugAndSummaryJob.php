<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\LLMService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateSlugAndSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }

    public function handle(LLMService $llmService)
    {
        $article = Article::find($this->articleId);
        if (!$article) return;

        // Generate slug and summary using LLM
        $slug = $llmService->generateSlug($article->title);
        $summary = $llmService->generateSummary($article->content);

        $article->update([
            'slug' => $slug,
            'summary' => $summary,
        ]);
    }
}

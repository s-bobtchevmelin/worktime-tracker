<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class TagRepository
{
    public static function getOrCreateTag(int $userId, string $tagLabel): Tag
    {
        $tag = Tag::where('user_id', $userId)->where('label', $tagLabel)->first();
        
        if(!$tag) {
            $tag = Tag::create([
                'label' => $tagLabel,
                'color' => 'primary',
                'user_id' => $userId
            ]);
        }

        return $tag;
    }
}

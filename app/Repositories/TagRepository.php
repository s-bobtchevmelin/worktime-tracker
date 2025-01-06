<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public static function getOrCreateTag(int $userId, string $tagLabel): Tag
    {
        $tag = Tag::where('user_id', $userId)->where('label', $tagLabel)->first();
        
        if(!$tag) {
            $tag = Tag::create([
                'label' => $tagLabel,
                'color' => 'grey',
                'user_id' => $userId
            ]);
        }

        return $tag;
    }
}

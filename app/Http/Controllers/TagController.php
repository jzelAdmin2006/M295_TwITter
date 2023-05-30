<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
    public function top()
    {
        return TagResource::collection(
            Tag::withCount('tweets')->orderBy('tweets_count', 'desc')->take(3)->get()
        );
    }
}

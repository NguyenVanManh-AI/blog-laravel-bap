<?php

namespace App\Http\Controllers;

use App\Services\LikedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikedController extends Controller
{
    protected LikedService $likedService;

    public function __construct(LikedService $likedService)
    {
        $this->likedService = $likedService;
    }

    /**
     * likeArticle
     *
     * @param Request $request
     */
    public function likeArticle(Request $request)
    {
        $input = (object) [
            'id_user' => Auth::guard('user')->user()->id,
            'id_article' => $request->id_article,
            'is_like' => $request->is_like,
        ];

        return $this->likedService->likeArticle($input);
    }

    /**
     * listLike
     *
     * @param Request $request
     */
    public function listLike(Request $request)
    {
        return $this->likedService->listLike($request->id_article);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShortLinkRequest;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ShortLinkController extends Controller
{

    public function index(Request $request)
    {
        $links = $request->user()->shortLinks()->latest()->get();
        Log::info($links);
         return response()->json($links, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortLinkRequest $request)
    {
        $user = $request->user();
        $code = $request->input('custom_code') ?? Str::random(6);

        $shortLink = ShortLink::create([
            'user_id' => $user->id,
            'original_url' => $request->original_url,
            'code' => $code,
        ]);

        return response()->json([
            "id"=>$shortLink->id,
            "user_id"=>$shortLink->user_id,
            "original_url" => $shortLink->original_url,
            "code"=>$shortLink->code,
            "clicks"=>$shortLink->clicks,
            "created_at"=>$shortLink->created_at,
        ], 201);
    }

    public function redirect($code)
    {
        $shortLink = ShortLink::where('code', $code)->firstOrFail();
        $shortLink->increment('clicks');
        return redirect()->away($shortLink->original_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $link = ShortLink::where('user_id', $request->user()->id)->findOrFail($id);
        if(!$link){
            return response()->json([
                "message"=>"Link not found"
            ],404);
        }
        $link->delete();
        return response()->json([
            "message"=>"Link deleted successfully"
        ],200);
    }


}






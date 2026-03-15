<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function messages(Request $request)
    {
        $limit = min((int) $request->input('limit', 50), 100);
        $site = $request->input('site');

        $query = ChatMessage::query();

        if ($site) {
            $query->where(function ($q) use ($site) {
                $q->whereNull('site')->orWhere('site', $site);
            });
        }

        if ($beforeId = (int) $request->input('before_id')) {
            $query->where('id', '<', $beforeId);
        }

        $messages = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get(['id', 'username', 'avatar_color', 'message', 'type', 'likes', 'created_at'])
            ->reverse()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $messages,
            'hasMore' => $messages->count() === $limit,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'message' => 'required|string|max:500',
        ]);

        $colors = ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e'];

        $msg = ChatMessage::create([
            'username' => $request->input('username'),
            'avatar_color' => $colors[array_rand($colors)],
            'message' => $request->input('message'),
            'type' => 'user',
            'is_fake' => false,
            'site' => $request->input('site'),
            'likes' => 0,
        ]);

        return response()->json([
            'success' => true,
            'data' => $msg->only(['id', 'username', 'avatar_color', 'message', 'type', 'likes', 'created_at']),
        ]);
    }

    public function like(int $id)
    {
        ChatMessage::where('id', $id)->increment('likes');

        return response()->json(['success' => true]);
    }

    public function online()
    {
        $hour = now('Asia/Ho_Chi_Minh')->hour;

        if ($hour >= 17 && $hour <= 20) $base = 150;
        elseif ($hour >= 10 && $hour <= 16) $base = 80;
        elseif ($hour >= 21 && $hour <= 23) $base = 100;
        else $base = 30;

        return response()->json([
            'success' => true,
            'online' => max(10, $base + rand(-20, 20)),
        ]);
    }
}

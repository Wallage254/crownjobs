<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function index(): JsonResponse
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return response()->json($messages);
    }

    public function show(string $id): JsonResponse
    {
        $message = Message::findOrFail($id);
        return response()->json($message);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = Message::create($validated);
        return response()->json($message, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        $validated = $request->validate([
            'is_read' => 'boolean',
        ]);

        $message->update($validated);
        return response()->json($message);
    }

    public function destroy(string $id): JsonResponse
    {
        $message = Message::findOrFail($id);
        $message->delete();
        
        return response()->json(['message' => 'Message deleted successfully']);
    }
}

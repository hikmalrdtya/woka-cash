<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->post('https://api.groq.com/openai/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $request->message
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1024,
                ]
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function voiceToText(Request $request)
    {
        try {
            $audio = $request->file('audio');

            $client = new \GuzzleHttp\Client();

            $res = $client->post("https://api.groq.com/openai/v1/audio/transcriptions", [
                "headers" => [
                    "Authorization" => "Bearer " . env("GROQ_API_KEY"),
                ],
                "multipart" => [
                    [
                        "name" => "file",
                        "contents" => fopen($audio->getPathname(), 'r'),
                        "filename" => "audio.webm"
                    ],
                    [
                        "name" => "model",
                        "contents" => "whisper-large-v3"
                    ],
                ]
            ]);

            return response()->json(json_decode($res->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}

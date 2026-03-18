<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->message;

        $systemPrompt = <<<PROMPT
Te egy LuxCar AI asszisztens vagy.
Segítesz autóválasztásban, röviden, érthetően, magyarul válaszolsz.
Csak autókkal, ajánlatkéréssel, felszereltséggel, árakkal és választási tanácsokkal kapcsolatban segíts.
PROMPT;

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->withoutVerifying()
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-4.1-mini',
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [
                            ['type' => 'input_text', 'text' => $systemPrompt]
                        ]
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'input_text', 'text' => $userMessage]
                        ]
                    ]
                ]
            ]);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'AI hívás sikertelen',
                'error' => $response->json(),
                'raw' => $response->body(),
                'status' => $response->status()
            ], 500);
        }

        return response()->json($response->json());
    }
}

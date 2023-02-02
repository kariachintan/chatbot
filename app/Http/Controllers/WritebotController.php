<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class WritebotController extends Controller
{
    public function generateResponse(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'prompt' => 'required|string|max:1024'
        ]);

        // Create a new OpenAI client
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        // Set up the GPT-3 request
        $response = $client->completions()->create([
            'model' => 'text-davinci-002',
            'prompt' => $validatedData['prompt'],
            'max_tokens' => 2048,
            'temperature' => 0.5,
        ]);


        // Render the view and pass the response
        return view('writebot', [
            'response' => $response->choices[0]->text
        ]);
    }
}

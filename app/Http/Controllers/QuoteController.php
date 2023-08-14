<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class QuoteController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quoteData = Quote::all();
        $formattedData = [];
        foreach ($quoteData as $quote) {
            $formattedData[] = [
                'quote' => $quote['quote'],
                'image' => $quote['image'],
            ];
        }
        return $this->sendResponse(QuoteResource::collection($formattedData), 'All quotes retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'quote' => 'required',
            'character' => 'required',
            'image' => 'required',
            'characterDirection' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $quote = Quote::create($input);
        return $this->sendResponse(new QuoteResource($quote), 'Quote created successfully');
    }

    public function fetchAndStoreQuotes(): \Illuminate\Http\JsonResponse
    {
        try {
            $response = Http::get('https://thesimpsonsquoteapi.glitch.me/quotes?count=1');
            $quoteData = $response->json()[0];
            $newQuote = new Quote([
                'quote' => $quoteData['quote'],
                'character' => $quoteData['character'],
                'image' => $quoteData['image'],
                'characterDirection' => $quoteData['characterDirection'],
            ]);
            $newQuote->save();

            $this->removeExcessQuotes();

            return $this->sendResponse(new QuoteResource($newQuote), 'Quote retrieved and updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching and storing the quote'], 500);
        }
    }

    protected function removeExcessQuotes(): void
    {
        $quoteCount = Quote::count();

        if ($quoteCount > 5) {
            $oldestQuotes = Quote::orderBy('created_at')->limit($quoteCount - 5)->get();
            foreach ($oldestQuotes as $oldestQuote) {
                $oldestQuote->delete();
            }
        }
    }

}

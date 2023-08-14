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
        $quote = Quote::all();
        return $this->sendResponse(QuoteResource::collection($quote), 'All quotes retrieved successfully.');
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

    /**
     * Retrieve Quote
     * @OA\Post (
     *     path="/api/quotes/fetch",
     *     tags={"quote"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="quote",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="character",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="characterDirection",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "quote": "Shoplifting is a victimless crime, like punching someone in the dark.",
     *                      "character": "Nelson Muntz",
     *                      "image" : "https://cdn.glitch.com/3c3ffadc-3406-4440-bb95-d40ec8fcde72%2FNelsonMuntz.png?1497567511185",
     *                      "characterDirection" : "Left"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="quote", type="string", example="quote"),
     *              @OA\Property(property="character", type="string", example="character"),
     *              @OA\Property(property="image", type="string", example="image"),
     *              @OA\Property(property="characterDirection", type="string", example="characterDirection"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
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

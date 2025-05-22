<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\EncryptionHelper;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        // TANPA PENJAGAAN APA APA
        // $products = Product::get();
        // return response()->json($products);

        // UNTUK PENJAGAAN KEAMANAN PERTAMA
        // $client = $request->get('authenticated_client');
        // return response()->json($client->products()->get());

        $client = $request->get('authenticated_client');  // Assuming ClientAuth middleware is working
        $products = $client->products()->get();  // Fetch the products for the authenticated client

        // Prepare the response data
        $responseData = [
            'message' => 'Success',
            'data' => $products,
        ];

        // Encrypt the response data
        $encryptedResponse = EncryptionHelper::encrypt(json_encode($responseData));

        // Return the encrypted response
        return response()->json(['data' => $encryptedResponse]);
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
        ]);

        try {
            // Create a new product and store it in the database
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'client_id' => $validated['client_id'],
            ]);

            // Prepare the response data
            $responseData = [
                'message' => 'Product created successfully',
                'data' => $product,
            ];

            // Encrypt the response data before returning
            $encryptedResponse = EncryptionHelper::encrypt(json_encode($responseData));

            // Return the encrypted response
            return response()->json(['data' => $encryptedResponse]);
        } catch (\Exception $e) {
            // If something goes wrong, return an error message
            return response()->json([
                'error' => 'Error storing product: ' . $e->getMessage(),
            ], 500);
        }
    }
}

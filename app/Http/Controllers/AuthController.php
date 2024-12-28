<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','tuttiUtenti']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

       /*  return $this->respondWithToken($token); */

          // Recupera l'utente autenticato
    $user = auth()->user();

    // Rispondi con il token e il ruolo dell'utente
    return response()->json([
        'token' => $this->respondWithToken($token),
        'role' => $user->role, // Aggiungi il ruolo dell'utente alla risposta
    ]);
    }

    public function register(Request $request)
    {
       
     // Recupera tutti i dati inviati dal form
    //$formData = $request->all();

     // Validazione dei dati
     $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // Se la validazione passa, creazione dell'utente
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')), // Hash della password
    ]);

    // Risposta JSON
    return response()->json([
        'success' => true,
        'message' => 'Registrazione avvenuta con successo',
        'data' => $user, // Puoi ritornare i dettagli dell'utente creato
    ], 201);



    // Puoi restituire i dati come JSON per verificare che vengano ricevuti correttamente
    return response()->json([
        'success' => true,
        'data' => $formData,
    ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function tuttiUtenti()
    {
        $allUtenti = User::all();
        return response()->json($allUtenti);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Credenziali non valide'], 401);
            }

            // Memorizza lo stato di login dell'utente
            Cache::put('user_logged_' . $credentials['email'], true, now()->addHours(24));

            $user = auth()->user();
            $decoded = JWTAuth::setToken($token)->getPayload();

            return response()->json([
                'token'    => $this->respondWithToken($token),
                'name'     => $user->name,
                'mail'     => $user->email,
                'password' => $user->password,
                'role'     => $decoded->get('role'),
            ]);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Errore durante la creazione del token'], 500);
        }
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
        'data-form' => $formData
    ], 201);


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
        try {
            // Ottieni l'utente prima di fare logout
            $user = auth()->user();
            
            if (!$user) {
                return response()->json(['error' => 'Utente non trovato'], 401);
            }

            // Rimuovi lo stato di login dalla cache PRIMA del logout
            Cache::forget('user_logged_' . $user->email);
            
            // Invalida il token JWT
            $token = auth()->getToken();
            JWTAuth::setToken($token)->invalidate();
            
            // Esegui il logout
            auth()->logout(true);

            return response()->json([
                'message' => 'Logout effettuato con successo',
                'email' => $user->email // per debug
            ]);
            
        } catch (JWTException $e) {
            /* \Log::error('Errore JWT durante il logout: ' . $e->getMessage()); */
            
            // In caso di errore, assicuriamoci comunque di pulire la cache
            if ($user = auth()->user()) {
                Cache::forget('user_logged_' . $user->email);
            }
            
            return response()->json(['error' => 'Errore durante il logout'], 500);
        } catch (\Exception $e) {
            /* \Log::error('Errore generico durante il logout: ' . $e->getMessage()); */
            return response()->json(['error' => 'Errore durante il logout'], 500);
        }
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
            'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_at' => now()->addMinutes(auth()->factory()->getTTL())->format('Y-m-d H:i:s')
        ]);
    }
}
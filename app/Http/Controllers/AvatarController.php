<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $customer = auth('customer')->user();
            
            // Gestisci il file
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Sposta il file nella cartella public/images/avatars
            $file->move(public_path('images/avatars'), $fileName);
            
            // Aggiorna il campo avatar del customer a true
            $customer->update([
                'avatar' => true
            ]);

            // Aggiorna o crea il record dell'avatar
            $avatar = $customer->avatar()->updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'path' => 'images/avatars/' . $fileName,
                    'file_name' => $fileName,
                    'nome_originale' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'dimensione' => $file->getSize()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Avatar caricato con successo',
                'avatar' => $avatar
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore durante il caricamento dell\'avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete()
    {
        try {
            $customer = auth('customer')->user();
            $avatar = $customer->avatar;

            if ($avatar) {
                // Elimina il file se esiste e non è l'immagine default
                if ($avatar->path !== 'images/avatars/default.jpg' && file_exists(public_path($avatar->path))) {
                    unlink(public_path($avatar->path));
                }

                // Reimposta l'avatar predefinito
                $avatar->update([
                    'path' => 'images/avatars/default.jpg',
                    'file_name' => 'default.jpg',
                    'nome_originale' => 'default.jpg',
                    'mime_type' => 'image/jpeg',
                    'dimensione' => null
                ]);

                // Imposta il campo avatar a false
                $customer->update([
                    'avatar' => false
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Avatar eliminato con successo'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'eliminazione dell\'avatar: ' . $e->getMessage()
            ], 500);
        }
    }
} 
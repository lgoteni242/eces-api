<?php

namespace App\Http\Controllers\Groupe3;

use App\Http\Controllers\Controller;
use App\Models\Groupe3Image;
use App\Models\Groupe3Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Upload une image pour une salle
     */
    public function uploadSalleImage(Request $request, $salleId)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $salle = Groupe3Salle::findOrFail($salleId);
        $file = $request->file('file');

        // Générer un nom de fichier unique
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Chemin de stockage
        $path = "groupe-3/salles/{$filename}";
        $storedPath = $file->storeAs("public/groupe-3/salles", $filename);

        // Générer l'URL publique
        $url = Storage::url($storedPath);

        // Enregistrer dans la base de données
        $image = Groupe3Image::create([
            'url' => $url,
            'path' => $path,
            'filename' => $filename,
            'salle_id' => $salleId,
        ]);

        return response()->json($image, 201);
    }

    /**
     * Récupérer les images d'une salle
     */
    public function getSalleImages($salleId)
    {
        $images = Groupe3Image::where('salle_id', $salleId)->get();

        return response()->json($images);
    }

    /**
     * Supprimer une image
     */
    public function deleteImage($imageId)
    {
        $image = Groupe3Image::findOrFail($imageId);

        // Supprimer le fichier du stockage
        $storagePath = 'public/' . $image->path;
        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }

        // Supprimer l'enregistrement de la base de données
        $image->delete();

        return response()->json(['message' => 'Image supprimée'], 200);
    }
}

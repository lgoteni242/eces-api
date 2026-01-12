<?php

namespace App\Http\Controllers\Groupe8;

use App\Http\Controllers\Controller;
use App\Models\Groupe8Image;
use App\Models\Groupe8Etablissement;
use App\Models\Groupe8Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Upload une image pour un établissement
     */
    public function uploadEtablissementImage(Request $request, $etablissementId)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $etablissement = Groupe8Etablissement::findOrFail($etablissementId);
        $file = $request->file('file');

        // Générer un nom de fichier unique
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Chemin de stockage
        $path = "groupe-8/etablissements/{$filename}";
        $storedPath = $file->storeAs("public/groupe-8/etablissements", $filename);

        // Générer l'URL publique
        $url = Storage::url($storedPath);

        // Enregistrer dans la base de données
        $image = Groupe8Image::create([
            'url' => $url,
            'path' => $path,
            'filename' => $filename,
            'imageable_type' => Groupe8Etablissement::class,
            'imageable_id' => $etablissementId,
        ]);

        return response()->json($image, 201);
    }

    /**
     * Upload une image pour un avis
     */
    public function uploadAvisImage(Request $request, $avisId)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $avis = Groupe8Avis::findOrFail($avisId);
        $file = $request->file('file');

        // Générer un nom de fichier unique
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Chemin de stockage
        $path = "groupe-8/avis/{$filename}";
        $storedPath = $file->storeAs("public/groupe-8/avis", $filename);

        // Générer l'URL publique
        $url = Storage::url($storedPath);

        // Enregistrer dans la base de données
        $image = Groupe8Image::create([
            'url' => $url,
            'path' => $path,
            'filename' => $filename,
            'imageable_type' => Groupe8Avis::class,
            'imageable_id' => $avisId,
        ]);

        return response()->json($image, 201);
    }

    /**
     * Récupérer les images d'un établissement
     */
    public function getEtablissementImages($etablissementId)
    {
        $images = Groupe8Image::where('imageable_type', Groupe8Etablissement::class)
            ->where('imageable_id', $etablissementId)
            ->get();

        return response()->json($images);
    }

    /**
     * Récupérer les images d'un avis
     */
    public function getAvisImages($avisId)
    {
        $images = Groupe8Image::where('imageable_type', Groupe8Avis::class)
            ->where('imageable_id', $avisId)
            ->get();

        return response()->json($images);
    }

    /**
     * Supprimer une image
     */
    public function deleteImage($imageId, Request $request)
    {
        $image = Groupe8Image::findOrFail($imageId);

        // Vérifier les permissions
        if ($image->imageable_type === Groupe8Avis::class) {
            // Pour les images d'avis, seul le propriétaire de l'avis ou un admin peut supprimer
            $avis = Groupe8Avis::find($image->imageable_id);
            if ($avis && $avis->user_id !== $request->user()->id && $request->user()->groupe8_role !== 'admin') {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
        } elseif ($image->imageable_type === Groupe8Etablissement::class) {
            // Pour les images d'établissement, seul un admin peut supprimer
            if ($request->user()->groupe8_role !== 'admin') {
                return response()->json(['message' => 'Seuls les administrateurs peuvent supprimer les images d\'établissements'], 403);
            }
        }

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

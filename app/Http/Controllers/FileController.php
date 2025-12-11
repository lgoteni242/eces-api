<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Upload une image
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max
            'groupe' => 'required|integer|min:1|max:10',
            'type' => 'nullable|string', // product, post, cours, avatar, etc.
        ]);

        $file = $request->file('file');
        $groupe = $request->input('groupe');
        $type = $request->input('type', 'general');

        // Générer un nom de fichier unique
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Chemin de stockage : storage/app/public/groupe-{n}/{type}/
        $path = "groupe-{$groupe}/{$type}/{$filename}";

        // Stocker le fichier
        $storedPath = $file->storeAs("public/groupe-{$groupe}/{$type}", $filename);

        // Générer l'URL publique
        $url = Storage::url($storedPath);

        return response()->json([
            'url' => $url,
            'path' => $path,
            'filename' => $filename,
        ], 201);
    }

    /**
     * Upload un fichier (document, PDF, etc.)
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:5120', // 5MB max
            'groupe' => 'required|integer|min:1|max:10',
            'type' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $groupe = $request->input('groupe');
        $type = $request->input('type', 'documents');

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "groupe-{$groupe}/{$type}/{$filename}";

        $storedPath = $file->storeAs("public/groupe-{$groupe}/{$type}", $filename);
        $url = Storage::url($storedPath);

        return response()->json([
            'url' => $url,
            'path' => $path,
            'filename' => $filename,
        ], 201);
    }

    /**
     * Supprimer un fichier
     */
    public function deleteFile(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->input('path');
        
        // Vérifier que le chemin commence par public/
        if (!str_starts_with($path, 'public/')) {
            $path = 'public/' . $path;
        }

        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['message' => 'Fichier supprimé'], 200);
        }

        return response()->json(['message' => 'Fichier non trouvé'], 404);
    }
}


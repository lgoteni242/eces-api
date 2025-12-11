<?php

namespace App\Http\Controllers\Groupe6;

use App\Http\Controllers\Controller;
use App\Models\Groupe6Quiz;
use App\Models\Groupe6Cours;
use App\Models\Groupe6User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function store(Request $request, $coursId)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($coursId);

        $request->validate([
            'question' => 'required|string',
            'reponses' => 'required|array',
            'reponse_correcte' => 'required|integer',
        ]);

        $quiz = Groupe6Quiz::create([
            'cours_id' => $coursId,
            'question' => $request->question,
            'reponses' => json_encode($request->reponses),
            'reponse_correcte' => $request->reponse_correcte,
        ]);

        return response()->json($quiz, 201);
    }

    public function update(Request $request, $coursId, $id)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($coursId);

        $quiz = Groupe6Quiz::where('cours_id', $coursId)
            ->findOrFail($id);

        $request->validate([
            'question' => 'sometimes|string',
            'reponses' => 'sometimes|array',
            'reponse_correcte' => 'sometimes|integer',
        ]);

        if ($request->has('reponses')) {
            $request->merge(['reponses' => json_encode($request->reponses)]);
        }

        $quiz->update($request->all());

        return response()->json($quiz);
    }

    public function destroy($coursId, $id, Request $request)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($coursId);

        $quiz = Groupe6Quiz::where('cours_id', $coursId)
            ->findOrFail($id);

        $quiz->delete();

        return response()->json(['message' => 'Quiz supprimé'], 200);
    }
}


<?php

namespace App\Http\Controllers\Groupe4;

use App\Http\Controllers\Controller;
use App\Models\Groupe4Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show(Request $request)
    {
        $profil = Groupe4Profil::where('user_id', $request->user()->id)
            ->with('user')
            ->firstOrFail();

        return response()->json($profil);
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|string',
        ]);

        $profil = Groupe4Profil::where('user_id', $request->user()->id)->first();

        if (!$profil) {
            $profil = Groupe4Profil::create([
                'user_id' => $request->user()->id,
                'bio' => $request->bio ?? '',
                'avatar' => $request->avatar,
            ]);
        } else {
            $profil->update($request->only(['bio', 'avatar']));
        }

        return response()->json($profil->load('user'));
    }
}


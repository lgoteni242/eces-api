<?php

namespace App\Http\Controllers\Groupe4;

use App\Http\Controllers\Controller;
use App\Models\Groupe4Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Envoyer un message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        // Ne pas permettre d'envoyer un message à soi-même
        if ($request->receiver_id == $request->user()->id) {
            return response()->json(['error' => 'Vous ne pouvez pas vous envoyer un message à vous-même'], 400);
        }

        $message = Groupe4Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message->load(['sender', 'receiver']), 201);
    }

    /**
     * Récupérer les conversations (liste des utilisateurs avec qui on a échangé)
     */
    public function getConversations(Request $request)
    {
        $userId = $request->user()->id;

        // Récupérer les conversations : utilisateurs avec qui on a échangé
        $conversations = Groupe4Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($message) use ($userId) {
            // Grouper par l'autre utilisateur (celui qui n'est pas l'utilisateur actuel)
            return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
        })
        ->map(function ($messages, $otherUserId) use ($userId) {
            $lastMessage = $messages->first();
            $otherUser = $lastMessage->sender_id == $userId ? $lastMessage->receiver : $lastMessage->sender;
            
            // Compter les messages non lus
            $unreadCount = Groupe4Message::where('sender_id', $otherUserId)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();

            return [
                'user' => [
                    'id' => $otherUser->id,
                    'name' => $otherUser->name,
                    'email' => $otherUser->email,
                    'avatar' => $otherUser->groupe4Profil->avatar ?? null,
                ],
                'last_message' => [
                    'id' => $lastMessage->id,
                    'message' => $lastMessage->message,
                    'created_at' => $lastMessage->created_at,
                    'is_from_me' => $lastMessage->sender_id == $userId,
                ],
                'unread_count' => $unreadCount,
            ];
        })
        ->values();

        return response()->json($conversations);
    }

    /**
     * Récupérer les messages d'une conversation avec un utilisateur spécifique
     */
    public function getMessages(Request $request, $userId)
    {
        $currentUserId = $request->user()->id;

        // Vérifier que l'utilisateur existe
        $otherUser = User::findOrFail($userId);

        // Récupérer les messages entre les deux utilisateurs
        $messages = Groupe4Message::where(function ($query) use ($currentUserId, $userId) {
            $query->where(function ($q) use ($currentUserId, $userId) {
                $q->where('sender_id', $currentUserId)
                  ->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($currentUserId, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $currentUserId);
            });
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->paginate(50);

        // Marquer les messages reçus comme lus
        Groupe4Message::where('sender_id', $userId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json($messages);
    }

    /**
     * Marquer tous les messages d'une conversation comme lus
     */
    public function markAsRead(Request $request, $userId)
    {
        $currentUserId = $request->user()->id;

        Groupe4Message::where('sender_id', $userId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['message' => 'Messages marqués comme lus']);
    }

    /**
     * Compter les messages non lus
     */
    public function getUnreadCount(Request $request)
    {
        $unreadCount = Groupe4Message::where('receiver_id', $request->user()->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * Supprimer un message
     */
    public function deleteMessage(Request $request, $messageId)
    {
        $message = Groupe4Message::where(function ($query) use ($request, $messageId) {
            $query->where('id', $messageId)
                  ->where(function ($q) use ($request) {
                      $q->where('sender_id', $request->user()->id)
                        ->orWhere('receiver_id', $request->user()->id);
                  });
        })->firstOrFail();

        $message->delete();

        return response()->json(['message' => 'Message supprimé']);
    }
}

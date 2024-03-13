<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;


class RegistrationController extends Controller
{
    public function register(Request $request, $eventId)
    {

        // Verifica que el usuario este autenticado
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        // Registra un usuario en un evento
        $registration = new Registration;
        $registration->event_id = $eventId;
        $registration->user_id = $request->user()->id;
        $registration->save();
        return response()->json($registration, 201);
    }

    public function unregister($eventId)
    {
        // Desregistra un usuario de un evento
        $registration = Registration::where('event_id', $eventId)->where('user_id', auth()->id())->first();
        if ($registration) {
            $registration->delete();
            return response()->json(null, 204);
        }
        return response()->json(['error' => 'No se encontró la inscripción'], 404);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    // Mostrar todas las notificaciones
    public function index()
    {
        // Obtener las notificaciones del usuario autenticado
        $notificaciones = auth()->user()->notifications;

        // Retornar una vista con las notificaciones
        return view('notificaciones.index', compact('notificaciones'));
    }

    // Mostrar una notificación específica y marcarla como leída
    public function show($id)
    {
        // Buscar la notificación por su ID
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            // Marcar la notificación como leída
            $notification->markAsRead();

            // Lógica adicional para mostrar detalles de la notificación (si es necesario)
            return view('notificaciones.show', compact('notification'));
        }

        // Si la notificación no existe o no pertenece al usuario, redirigir
        return redirect()->route('notificaciones.index')->with('error', 'Notificación no encontrada.');
    }

    // Marcar todas las notificaciones como leídas
    public function markAllAsRead()
    {
        // Marcar todas las notificaciones como leídas
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Todas las notificaciones han sido marcadas como leídas.');
    }

    // Eliminar una notificación específica
    public function destroy($id)
    {
        // Buscar y eliminar la notificación
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->delete();
            return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada.');
        }

        return redirect()->route('notificaciones.index')->with('error', 'Notificación no encontrada.');
    }

   

}

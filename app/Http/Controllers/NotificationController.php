<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ResponseFormatter;

    /**
     * Get all notifications for the authenticated user.
     */
    public function index(): JsonResponse
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        $response = NotificationResource::collection($notifications);

        return $this->successResponse($response, 'Daftar notifikasi berhasil diambil');
    }

    /**
     * Mark a single notification as read and return its detail.
     */
    public function read(string $id): JsonResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return $this->successResponse(
            new NotificationResource($notification),
            'Notifikasi berhasil dibaca'
        );
    }

    /**
     * Mark all notifications as read.
     */
    public function readAll(): JsonResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return $this->successResponse(null, 'Semua notifikasi berhasil ditandai sebagai dibaca');
    }

    /**
     * Delete a single notification.
     */
    public function destroy(string $id): JsonResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return $this->successResponse(null, 'Notifikasi berhasil dihapus');
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function destroyAll(): JsonResponse
    {
        auth()->user()->notifications()->delete();

        return $this->successResponse(null, 'Semua notifikasi berhasil dihapus');
    }
}

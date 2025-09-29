<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="Puspa API Documentation",
 * description="Dokumentasi API lengkap untuk layanan Puspa",
 * @OA\Contact(
 * email="admin@puspa.sinus.ac.id"
 * )
 * )
 *
 * @OA\Server(
 * url=L5_SWAGGER_CONST_HOST,
 * description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * description="Masukkan token Bearer Anda"
 * )
 *
 * @OA\Tag(name="Authentication", description="Endpoint untuk otentikasi, registrasi, dan manajemen password.")
 * @OA\Tag(name="Registrations", description="Endpoint untuk pendaftaran keluarga baru (wali & anak).")
 * @OA\Tag(name="Email Verification", description="Endpoint untuk verifikasi email pengguna.")
 * @OA\Tag(name="Admins", description="Endpoint untuk mengelola data admin (khusus Super Admin).")
 * @OA\Tag(name="Therapists", description="Endpoint untuk mengelola data terapis (khusus Admin).")
 * @OA\Tag(name="Observations", description="Endpoint untuk melihat dan mengelola data observasi.")
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}

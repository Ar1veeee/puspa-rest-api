<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background-color: #f8fbfa; padding: 30px; text-align: center; border-bottom: 1px solid #e8f4f2;">
                            <img src="https://res.cloudinary.com/dlcdkyvrf/image/upload/v1757392191/logo-puspa_wgfp3a.png"
                                alt="<?php echo e(config('app.name')); ?>" width="280" style="max-width: 100%; height: auto;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h1
                                style="margin: 0 0 20px 0; font-size: 24px; font-weight: normal; color: #2c3e50; text-align: center;">
                                Verifikasi Email Anda</h1>

                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #2c3e50; font-weight: 500;">
                                Selamat datang <?php echo e($user->username ?? 'User'); ?>,
                            </p>

                            <p style="margin: 0 0 20px 0; font-size: 15px; color: #5a6c7d; line-height: 1.6;">
                                Terima kasih telah mendaftar di <?php echo e(config('app.name')); ?>. Untuk mengaktifkan akun Anda
                                dan mulai menggunakan layanan kami, silakan verifikasi alamat email Anda.
                            </p>

                            <p style="margin: 0 0 30px 0; font-size: 15px; color: #5a6c7d; line-height: 1.6;">
                                Klik tombol di bawah ini untuk memverifikasi email Anda:
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="background-color: #2ab3a2; border-radius: 25px; padding: 0;">
                                                    <a href="<?php echo e($url); ?>"
                                                        style="display: block; padding: 15px 30px; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; text-align: center;">Verifikasi
                                                        Email Saya</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Notice Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td
                                        style="background-color: #f8fbfa; border-left: 4px solid #2ab3a2; padding: 15px 20px;">
                                        <p style="margin: 0; font-size: 14px; color: #2ab3a2; font-weight: 500;">
                                            <strong>Catatan:</strong> Jika Anda tidak melakukan pendaftaran, abaikan
                                            email ini. Akun tidak akan dibuat tanpa verifikasi email.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0 0 0; font-size: 14px; color: #7f8c8d; line-height: 1.5;">
                                Setelah verifikasi berhasil, Anda dapat login dan mulai menggunakan semua fitur yang
                                tersedia di platform kami.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fbfa; padding: 30px; border-top: 1px solid #e8f4f2;">
                            <p style="margin: 0 0 15px 0; font-size: 15px; color: #2c3e50;">
                                Selamat bergabung!
                            </p>
                            <p style="margin: 0 0 25px 0; font-size: 15px; color: #2ab3a2; font-weight: 600;">
                                Tim <?php echo e(config('app.name')); ?>

                            </p>

                            <!-- Backup Link -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td
                                        style="background-color: #ffffff; border: 1px solid #e8f4f2; border-radius: 6px; padding: 15px;">
                                        <p
                                            style="margin: 0 0 10px 0; font-size: 13px; color: #2c3e50; font-weight: 600;">
                                            Tidak bisa mengklik tombol?
                                        </p>
                                        <p style="margin: 0 0 8px 0; font-size: 13px; color: #7f8c8d;">
                                            Salin dan tempel URL berikut ke browser Anda:
                                        </p>
                                        <p
                                            style="margin: 0; background-color: #f8fbfa; padding: 8px 10px; border-radius: 4px; font-size: 11px; color: #2ab3a2; font-family: monospace; word-break: break-all;">
                                            <?php echo e($url); ?>

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH /home/ar1ve/Developments/laravel/puspa-api/resources/views/emails/email-verification.blade.php ENDPATH**/ ?>
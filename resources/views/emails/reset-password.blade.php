<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
                                alt="{{ config('app.name') }}" width="280" style="max-width: 100%; height: auto;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h1
                                style="margin: 0 0 20px 0; font-size: 24px; font-weight: normal; color: #2c3e50; text-align: center;">
                                Reset Password</h1>

                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #2c3e50; font-weight: 500;">
                                Halo {{ $user->username ?? 'User' }},
                            </p>

                            <p style="margin: 0 0 30px 0; font-size: 15px; color: #5a6c7d; line-height: 1.6;">
                                Kami menerima permintaan untuk mengatur ulang password akun Anda. Klik tombol di bawah
                                ini untuk melanjutkan proses reset password.
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="background-color: #2ab3a2; border-radius: 25px; padding: 0;">
                                                    <a href="{{ $url }}"
                                                        style="display: block; padding: 15px 30px; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; text-align: center;">Reset
                                                        Password Saya</a>
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
                                            <strong>Penting:</strong> Link ini akan kadaluwarsa dalam
                                            {{ config('auth.passwords.users.expire') }} menit untuk menjaga keamanan
                                            akun Anda.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0 0 0; font-size: 14px; color: #7f8c8d; line-height: 1.5;">
                                Jika Anda tidak meminta reset password, abaikan email ini. Password Anda akan tetap aman
                                dan tidak akan berubah.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fbfa; padding: 30px; border-top: 1px solid #e8f4f2;">
                            <p style="margin: 0 0 15px 0; font-size: 15px; color: #2c3e50;">
                                Salam hangat,
                            </p>
                            <p style="margin: 0 0 25px 0; font-size: 15px; color: #2ab3a2; font-weight: 600;">
                                Tim {{ config('app.name') }}
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
                                            {{ $url }}
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

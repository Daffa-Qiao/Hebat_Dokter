<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Email - Hebat Dokter</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #157347, #28a745); padding: 36px 40px; text-align: center; }
        .header img { height: 50px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; margin: 0; letter-spacing: 0.5px; }
        .body { padding: 40px; color: #333333; }
        .body p { font-size: 15px; line-height: 1.7; margin: 0 0 16px; }
        .code-box { background: #f0fdf4; border: 2px dashed #28a745; border-radius: 10px; text-align: center; padding: 24px; margin: 28px 0; }
        .code-box .code { font-size: 42px; font-weight: bold; letter-spacing: 12px; color: #157347; }
        .code-box .note { font-size: 13px; color: #6c757d; margin-top: 8px; }
        .warning { background: #fff8e1; border-left: 4px solid #ffc107; padding: 14px 18px; border-radius: 6px; font-size: 13px; color: #856404; margin-top: 20px; }
        .footer { background: #f8f9fa; text-align: center; padding: 24px 40px; font-size: 12px; color: #aaa; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🏥 Hebat Dokter</h1>
        </div>
        <div class="body">
            <p>Halo, <strong>{{ $userName }}</strong>!</p>
            <p>Terima kasih telah mendaftar di <strong>Hebat Dokter</strong>. Gunakan kode verifikasi berikut untuk mengkonfirmasi alamat email Anda:</p>

            <div class="code-box">
                <div class="code">{{ $code }}</div>
                <div class="note">Kode berlaku selama <strong>10 menit</strong></div>
            </div>

            <p>Masukkan kode di atas pada halaman verifikasi untuk mengaktifkan akun Anda.</p>

            <div class="warning">
                ⚠️ Jika Anda tidak mendaftar di Hebat Dokter, abaikan email ini. Jangan bagikan kode ini kepada siapapun.
            </div>
        </div>
        <div class="footer">
            © {{ date('Y') }} Hebat Dokter. Semua hak dilindungi.<br>
            Email ini dikirim secara otomatis, harap jangan membalas email ini.
        </div>
    </div>
</body>
</html>

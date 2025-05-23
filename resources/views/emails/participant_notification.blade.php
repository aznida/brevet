<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Peserta Ujian</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <img src="https://brempi.com/assets/images/Logo-color.png" alt="Logo" width="300" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0;">
                <h2>Hai, {{ $name }} 👋 !</h2>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8f9fa; border-left: 4px solid #28a745; padding: 15px; text-align: justify;">
                <p><strong>Assessment Brevetisasi</strong> menjadi salah satu tolok ukur keberhasilan TIF dalam mengembangkan kapabilitas teknisi melalui Learning dan Assessment. Assessment ini dilaksanakan untuk pemetaan skill dan level stream Teknisi MO DEFA sehingga dapat terus memberikan yang terbaik untuk perusahaan.</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0;">
                <p>Berikut adalah informasi akses Anda untuk Assessment Brevetisasi:</p>
                <ul>
                    <li>Akses dengan NIK: <strong>{{ $nik }}</strong></li>
                    <li>Kata Sandi: <strong>{{ $password }}</strong> <i>(Jika password tidak bisa silahkan lakukan forgot password)</i></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px 0;">
                <p>Silakan akses assesment brevetisasi melalui tombol di bawah ini:</p>
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center">
                            <a href="{{ $url }}" style="background-color: #28a745; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: bold; display: inline-block;">Dashboard Brevetisasi</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 15px 0;">
                            <a href="https://brempi.com" style="color: #666;">https://brempi.com</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px 0;">
                <p>Download Aplikasi Mobile:</p>
                <a href="https://brempi.com/assets/app/brempi.1.0.apk">
                    <img src="https://brempi.com/assets/images/android.png" alt="Download APK" height="40" style="display: block; margin: 0 auto;">
                </a>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 30px; border-top: 1px solid #eee;">
                <p>Terima Kasih,</p>
                <p><strong>TIM BREVETISASI MO DEFA</strong></p>
                
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px;">
                    <p><strong>Noted:</strong> Apabila terdapat pertanyaan lebih lanjut, silakan hubungi:</p>
                    <p>
                        Helpcare Brevet: <strong>+62852-1597-3482 (Made)</strong><br>
                        Telegram: <a href="https://t.me/madeadriandp" style="color: #0088cc; text-decoration: none;"><strong>@madeadriandp</strong></a>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
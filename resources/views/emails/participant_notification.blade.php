<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Peserta Ujian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            margin-bottom: 20px;
        }
        .btn-success {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #666;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        /* Perbaikan style untuk tombol */
        .button-container {
            margin: 20px 0;
            text-align: center;
        }
        
        .button-link {
            background-color: #28a745;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            border: 2px solid #28a745;
            /* Fallback untuk email client yang tidak mendukung CSS modern */
            mso-padding-alt: 0;
            mso-text-raise: 12pt;
        }
        
        /* Fallback untuk Outlook */
        * [lang=x-button] {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/header-brevetisasi.png'))) }}"
                     alt="Banner Brevetisasi" 
                     class="header-image"
                     style="width: 100%; max-width: 600px; height: auto; margin-bottom: 20px; display: block;">
            </td>
        </tr>
    </table>
    
    <h2>Hai, {{ $name }} 👋 !</h2>
    
    <div class="info-box" style="text-align: justify">
        <p><strong>Assessment Brevetisasi</strong> menjadi salah satu tolok ukur keberhasilan TIF dalam mengembangkan kapabilitas teknisi melalui Learning dan Assessment. Assessment ini dilaksanakan untuk pemetaan skill dan level stream Teknisi MO DEFA sehingga dapat terus memberikan yang terbaik untuk perusahaan.</p>
    </div>
    
    <p>Berikut adalah informasi akses Anda untuk Assessment Brevetisasi:</p>
    <ul>
        <li>Akses dengan NIK: <strong>{{ $nik }}</strong></li>
        <li>Kata Sandi: <strong>{{ $password }}</strong></li>
    </ul>
    
    <p>Silakan akses assesment brevetisasi melalui tombol di bawah ini:</p>
    <div class="button-container">
        <!--[if mso]>
        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" stroke="f" fillcolor="#28a745">
            <w:anchorlock/>
            <center>
        <![endif]-->
        <a href="{{ $url }}" class="button-link" target="_blank" lang="x-button">
            Dashboard Brevetisasi
        </a>
        <!--[if mso]>
            </center>
        </v:roundrect>
        <![endif]-->
    </div>
    
    <div class="footer">
        <p>Terima Kasih,</p>
        <p><strong>TIM BREVETISASI MO DEFA</strong></p>
        
        <div class="contact-info">
            <p><strong>Noted:</strong> Apabila terdapat pertanyaan lebih lanjut, silakan hubungi:</p>
            <p>
                Helpcare Brevet: <strong>+62852-1597-3482 (Made)</strong><br>
                Telegram: <a href="https://t.me/madeadriandp" style="color: #0088cc; text-decoration: none;"><strong>@madeadriandp</strong></a>
            </p>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Meta Tags untuk SEO dan Social Media Sharing -->
        <meta name="description" content="Brempi - Aplikasi Ujian Online Brevetisasi DEFA - Platform ujian online yang memungkinkan peserta untuk mengikuti ujian brevetisasi secara digital">
        <meta name="keywords" content="brevetisasi, ujian online, DEFA, sertifikasi, teknisi, ujian digital, pembelajaran online, Brempi">
        <meta name="author" content="Eko Wahyudi - DEFA">
        <meta name="robots" content="index, follow">
        
        <!-- Meta Tags untuk WhatsApp dan Social Media -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://brempi.com/">
        <meta property="og:title" content="Brempi - Brevetisasi Meraih Mimpi">
        <meta property="og:description" content="Platform ujian online brevetisasi yang memungkinkan peserta untuk mengikuti ujian sertifikasi teknisi secara digital. Tingkatkan kompetensimu bersama DEFA!">
        <meta property="og:image" content="https://diariumsrv.telkom.co.id/getfoto/970266">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="https://brempi.com/">
        <meta property="twitter:title" content="Brempi - Brevetisasi Meraih Mimpi">
        <meta property="twitter:description" content="Platform ujian online brevetisasi yang memungkinkan peserta untuk mengikuti ujian sertifikasi teknisi secara digital. Tingkatkan kompetensimu bersama DEFA!">
        <meta property="twitter:image" content="https://diariumsrv.telkom.co.id/getfoto/970266">
        
        <!-- WhatsApp -->
        <meta property="og:site_name" content="Brempi">
        <meta property="og:locale" content="id_ID">
        
        <title>Brempi - Brevetisasi Meraih Mimpi</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="{{ asset('assets/css/volt.css') }}" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
    <style>
        body {
            position: relative;
            background-color: #f5f8fb;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/assets/images/presence-doodle.png');
            background-repeat: repeat;
            background-size: 500px;
            opacity: 0.5;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>

<body>

	@inertia

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/smooth-scroll.polyfills.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/volt.js') }}"></script>
</body>
</html>
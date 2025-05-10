<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('{{ isset($is_pdf) && $is_pdf ? public_path('storage/bg-sertif.png') : asset('storage/bg-sertif.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        @font-face {
            font-family: 'Vivaldi';
            src: url('{{ storage_path('fonts/vivaldi.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .content {
            text-align: center;
            max-width: 90%;
            margin: 0 auto;
            /* padding-top: {{ isset($is_pdf) && $is_pdf ? '100px' : '200px' }}; */
            margin-top: {{ isset($is_pdf) && $is_pdf ? '40vh' : '50vh' }};
        }

        .given-text {
            font-size: {{ isset($is_pdf) && $is_pdf ? '24px' : '16px' }};
            margin: 10px 0;
            font-weight: bold;
            color: #003942;
        }

        .name {
            font-size: {{ isset($is_pdf) && $is_pdf ? '34px' : '24px' }};
            color: #003942;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            padding-bottom: 8px;
            padding-top: 8px;
            margin: 20px 0px;
        }

        .course-detail {
            font-size: {{ isset($is_pdf) && $is_pdf ? '22px' : '16px' }};
            color: #003942;
        }

        .tanggal {
            font-size: 16px;
            color: #003942;
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <div class="content" style="text-align: center; padding-top: {{ isset($is_pdf) && $is_pdf ? '280px' : '280px' }};">
        <p class="given-text">Diberikan kepada :</p>
        <p class="name" style="font-family: 'Vivaldi', cursive;">{{ $participant_name }}</p>
        <p class="course-detail">
            Atas penyelesaian kursus <strong>{{ $course_title }}</strong> dalam kategori {{ $course_category }}.
        </p>
        <p class="tanggal">Tanggal</p>
    </div>
</body>
</html>

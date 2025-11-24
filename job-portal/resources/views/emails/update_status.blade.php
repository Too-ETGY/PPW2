<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Lamaran Diperbarui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .box {
            background: #f7f7f7;
            border-left: 5px solid #4CAF50;
            padding: 10px 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Status Lamaran Anda Diperbarui</h2>

    <p>Halo {{ $application->user->name }},</p>

    <p>
        Status lamaran Anda untuk posisi
        <strong>{{ $application->job->title }}</strong>
        telah diperbarui.
    </p>

    <div class="box">
        <strong>Status Baru:</strong>  
        {{ ucfirst($application->status) }}
    </div>

    @if(!empty($application->notes))
    <p><strong>Catatan dari admin:</strong></p>
    <p>{{ $application->notes }}</p>
    @endif

    <p>Terima kasih telah melamar.</p>

    <div class="footer">
        <p>Email ini dikirim otomatis dari sistem Job Portal.</p>
    </div>

</div>

</body>
</html>

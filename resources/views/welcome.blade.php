<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Christmas Registration 2025 - Login Selection</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 320px;
        }
        h1 {
            margin-bottom: 1.5rem;
            color: #28a745;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        a.btn {
            display: block;
            padding: 0.75rem 1rem;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a.btn:hover {
            background-color: #218838;
        }
        i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-tree-christmas"></i> Christmas Registration 2025</h1>
        <p>Pilih jenis login untuk memulai:</p>
        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>@yield('title')</title>
</head>
<body>
    <section>
        <header class="mb-3">
            <nav class="navbar bg-primary px-5" data-bs-theme="primary">
                <div class="container-fluid">
                    <div class="navbar-brand">
                        <a href="{{ route('book.index') }}" class="fw-bold text-white navbar-brand">HOME</a>
                    </div>
                </div>
            </nav>
        </header>
    </section>
    <section class="container mt-5">
        <div class="mt-2">
            <h3>@yield('heading')</h3>
        </div>
        <div class="card p-4">
            @section('content') @show
        </div>
    </section>
@stack('scripts')
</body>
</html>

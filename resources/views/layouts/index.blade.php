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
    @include('layouts.navbar')

    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if(session('warning_attendance'))
            <div class="alert alert-warning">{{ session('warning_attendance') }}</div>
    @endif

    <section class="container mt-5">
        <div class="mt-2">
            <h3 class="fw-bold text-sm">@yield('heading')</h3>
        </div>
        <div class="card">
            <div class="card-header">
                @section('header') @show
            </div>
            <div class="card-body ">
                @section('table') @show
            </div>
        </div>
    </section>
    <script>
        $('#search').on('keyup',function(){
            let query = $(this).val();
            $.ajax({
                url: "{{ route('book.search') }}",
                type: 'GET',
                data: {search: query},
                success: function(data){
                    $('#books-table').html(data);
                }
            })
        })
        $(document).ready(function(){
            $('#categoryFilter').on('change', function(){
                let category = $(this).val();
                $.ajax({
                    url:"{{ route('book.category') }}",
                    type: 'GET',
                    data: {category:category},
                    success: function(data){
                        $('#books-table').html(data);
                    }
                })
            });
            $('#supplier').on('change', function(){
                let supplier = $(this).val();
                $.ajax({
                    url: "{{ route('book.supplier.filter') }}",
                    type: 'GET',
                    data: { supplier: supplier },
                    success: function(data){
                        $('#books-table').html(data);
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>

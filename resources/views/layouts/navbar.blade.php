<section>
    <header class="mb-3">
        <nav class="navbar bg-primary px-5" data-bs-theme="primary">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <a href="{{ route('book.index') }}" class="fw-bold text-white navbar-brand">HOME</a>
                    <a href="{{ route('book.trash') }}" class="btn text-warning fw-bold navbar-brand"> <img src="{{ asset('recycle.png') }}" width="35" height="35"> Trashed</a>
                </div>
                <form class="d-flex justify-center" >
                    <input type="search" placeholder="SEARCH" id="search" name="search" class="form-control me-2">
                </form>
                <a href="{{ route('order.create') }}" class="bg-dark rounded text-white px-2 py-1 text-decoration-none  fw-bold">🛒 Order</a>
            </div>
        </nav>
    </header>
</section>



<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Catalog - PT Aldmic COOPN Digital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <style>
        body { background-color: #f8f9fa; }
        .movie-card .thumbnail {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .movie-card .thumbnail:hover { transform: translateY(-5px); }
        .movie-card img { height: 350px; object-fit: cover; width: 100%; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="/">🎬 MovieApp</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/favorites">{{ __('messages.favorites_title') }}</a>
                    </li>
                </ul>
                <div class="navbar-nav ml-auto align-items-center">
                    <a href="/lang/en" class="nav-item nav-link mr-2 {{ app()->getLocale() == 'en' ? 'active font-weight-bold text-primary' : '' }}">EN</a>
                    <a href="/lang/id" class="nav-item nav-link mr-3 {{ app()->getLocale() == 'id' ? 'active font-weight-bold text-primary' : '' }}">ID</a>
                    
                    <a href="/logout" class="btn btn-sm btn-outline-danger">{{ __('messages.logout_btn') }}</a>
                </div>
            </div>
        </div>
    </nav>
    <div id="custom-alert" class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" 
        style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 320px;">
        <strong id="alert-title">Sukses!</strong> <span id="alert-message"></span>
        <button type="button" class="close" onclick="$('#custom-alert').fadeOut();" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Setup Token CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Alert Function (reusable function)
        function showAlert(message, type = 'success') {
            let alertEl = $('#custom-alert');
            let titleEl = $('#alert-title');
            let msgEl = $('#alert-message');

            msgEl.text(message);
            if (type === 'success') {
                titleEl.text('Sukses! ');
                alertEl.removeClass('alert-danger').addClass('alert-success').css('border-left', '5px solid #28a745');
            } else {
                titleEl.text('Error! ');
                alertEl.removeClass('alert-success').addClass('alert-danger').css('border-left', '5px solid #dc3545');
            }
            alertEl.stop(true, true).fadeIn().delay(3000).fadeOut();
        }

        // AddToFavorite Function (reusable for both index and detail page)
        function addToFavorite(imdbID, title, year, poster) {
            $.ajax({
                url: '/favorites/add',
                type: 'POST',
                data: {
                    // Tidak perlu _token lagi karena sudah di-handle oleh $.ajaxSetup di atas
                    imdbID: imdbID,
                    Title: title,
                    Year: year,
                    Poster: poster
                },
                success: function(response) {
                    if (response.status === 'success') {
                        showAlert('🎬 ' + title + ' {{ addslashes(__("messages.success_add_favorite")) }}', 'success');
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('{{ addslashes(__("messages.error_add_favorite")) }}', 'danger');
                }
            });
        }

        // RemoveFromFavorite Function (reusable for favorites page)
        function removeFromFavorite(imdbID, title) {
            if (confirm('{{ addslashes(__("messages.confirm_delete")) }} ' + title + ' {{ addslashes(__("messages.confirm_page")) }}')) {
                $.ajax({
                    url: '/favorites/delete/' + imdbID,
                    type: 'DELETE', // Menggunakan HTTP Method DELETE sesuai dengan rute Laravel
                    success: function(response) {
                        if (response.status === 'success') {
                            // 1. Tampilkan Alert Bootstrap reusable kita
                            showAlert('🗑️ ' + title + ' {{ addslashes(__("messages.success_delete")) }}', 'success');
                            
                            // 2. Hilangkan card film dari layar secara instan dengan animasi fadeOut
                            $('#movie-card-' + imdbID).fadeOut(500, function() {
                                $(this).remove();
                                
                                // Opsional: Jika film favorit di layar sudah habis (0), refresh halaman 
                                // agar layout kosong (partials.empty) otomatis muncul
                                if ($('.movie-card').length === 0) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function() {
                        showAlert('{{ addslashes(__("messages.error_delete")) }}', 'danger');
                    }
                });
            }
        }
    </script>
</body>
</html>
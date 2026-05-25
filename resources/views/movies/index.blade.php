@extends('layouts.app')

<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

@section('content')
<div class="container">
    
    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <form action="/" method="GET" class="input-group">
                <input type="text" name="s" class="form-control" placeholder="{{ trans('messages.search_placeholder') }}" value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">🔍 {{ trans('messages.search') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="movie-container" class="row">
        @if(isset($movies['Search']) && count($movies['Search']) > 0)
            @foreach($movies['Search'] as $movie)
                @php
                    $poster = ($movie['Poster'] !== 'N/A') ? $movie['Poster'] : 'https://via.placeholder.com/350x500?text=No+Image';
                @endphp
                <div class="col-md-3 movie-card mb-4">
                    <div class="thumbnail p-2 bg-white rounded shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <img data-src="{{ $poster }}" class="img-fluid rounded mb-2 lazyload" alt="{{ $movie['Title'] }}" style="height: 350px; object-fit: cover; width: 100%;">
                            
                            <h5 class="text-truncate px-1 mb-1" title="{{ $movie['Title'] }}" style="font-size: 1rem; font-weight: 600; color: #333;">
                                {{ $movie['Title'] }}
                            </h5>
                            <p class="text-muted small px-1 mb-3">📅 {{ $movie['Year'] }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto p-1">
                            <a href="/movie/{{ $movie['imdbID'] }}" class="btn btn-sm btn-info font-weight-bold">Detail</a>
                            <button onclick="addToFavorite('{{ $movie['imdbID'] }}', '{{ addslashes($movie['Title']) }}', '{{ $movie['Year'] }}', '{{ $movie['Poster'] }}')" class="btn btn-sm btn-warning font-weight-bold">
                                ⭐ Favorite
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @include('partials.empty')
        @endif
    </div>

    <div id="loading" class="text-center my-4" style="display: none;">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="text-muted mt-2">Loading movies...</p>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script>
    let page = 1; 
    let action = 'active'; 
    let searchStr = "{{ $search ?? 'Batman' }}"; 

    // Event Listener (Infinite Scroll)
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() > $("#movie-container").height() && action == 'active') {
            action = 'inactive'; 
            page++; 
            loadMoreData(page); 
        }
    });

    // Function Load Data 
    function loadMoreData(page) {
        $("#loading").show();

        $.ajax({
            url: '/?s=' + encodeURIComponent(searchStr) + '&page=' + page,
            type: "get",
            dataType: "json"
        })
        .done(function(data) {
            if (data.Response === "False" || data.Search === undefined || data.Search.length === 0) {
                $("#loading").html("<p class='text-muted my-3 font-weight-bold'>No more movies available.</p>");
                action = 'inactive'; 
                return;
            }

            $("#loading").hide();
            let html = '';
            
            data.Search.forEach(movie => {
                let poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/350x500?text=No+Image';
                let cleanTitle = movie.Title.replace(/'/g, "\\'");

                // IMPLEMENTASI LAZY LOAD DI AJAX (Menggunakan data-src dan class lazyload)
                html += `
                    <div class="col-md-3 movie-card mb-4">
                        <div class="thumbnail p-2 bg-white rounded shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div>
                                <img data-src="${poster}" class="img-fluid rounded mb-2 lazyload" alt="${movie.Title}" style="height: 350px; object-fit: cover; width: 100%;">
                                <h5 class="text-truncate px-1 mb-1" title="${movie.Title}" style="font-size: 1rem; font-weight: 600; color: #333;">
                                    ${movie.Title}
                                </h5>
                                <p class="text-muted small px-1 mb-3">📅 ${movie.Year}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto p-1">
                                <a href="/movie/${movie.imdbID}" class="btn btn-sm btn-info font-weight-bold">Detail</a>
                                <button onclick="addToFavorite('${movie.imdbID}', '${cleanTitle}', '${movie.Year}', '${movie.Poster}')" class="btn btn-sm btn-warning font-weight-bold">
                                    ⭐ Favorite
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            $("#movie-container").append(html);
            action = 'active'; // Buka kunci scroll kembali
        })
        .fail(function(xhr, status, error) {
            console.error("Error: ", error);
            $("#loading").html("<p class='text-danger my-3'>Failed to load data.</p>");
        });
    }
</script>
@endsection
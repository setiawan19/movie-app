@extends('layouts.app')

@section('content') 
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-dark">{{ trans('messages.favorites_title') ?? 'My Favorite Movies' }}</h2>
        <a href="/" class="btn btn-outline-secondary">{{ trans('messages.back_to_home') ?? 'Back to Home' }}</a>
    </div>
    <div class="row">
        @if(count($favorites) > 0)
            @foreach($favorites as $movie)
                <div class="col-md-3 movie-card mb-4" id="movie-card-{{ $movie['imdbID'] }}">
                    <div class="thumbnail p-2 bg-white rounded shadow-sm">
                        @php
                            $poster = ($movie['Poster'] !== 'N/A') ? $movie['Poster'] : 'https://via.placeholder.com/350x500?text=No+Image';
                        @endphp
                        <img src="{{ $poster }}" class="img-responsive rounded" alt="{{ $movie['Title'] }}" style="height: 350px; object-fit: cover; width: 100%;">
                        
                        <div class="caption mt-2">
                            <h5 class="text-truncate" title="{{ $movie['Title'] }}">{{ $movie['Title'] }} International ({{ $movie['Year'] }})</h5>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="/movie/{{ $movie['imdbID'] }}" class="btn btn-sm btn-info">Detail</a>
                                
                                <button onclick="removeFromFavorite('{{ $movie['imdbID'] }}', '{{ addslashes($movie['Title']) }}')" class="btn btn-sm btn-outline-danger">
                                    🗑️ Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @include('partials.empty')
        @endif
    </div>
</div>
@endsection
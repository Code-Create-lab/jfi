@extends('layouts.blank')

@section('title', '404 Error')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper">
<div class="section-banner-inner banner-inner-404">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="heading-notfound">404</h1>
<h3 class="secondary-accent">Oops! Court Not Found</h3>
<p class="description-notfound">

                            The page you're looking for has gone out of bounds. Let's get you back to the action.ng elit. Etiam dictum magna eget sem cursus porta. Cras dignissim tincidunt feugiat. Aenean feugiat eget purus non ornare.

                        </p>
<div>
<a class="btn btn-accent" href="{{ route('home') }}">
<span class="btn-title">

                                    Return to Home

                                </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
@endsection

@extends('site.templates.template')
@section('content')

    <div class="slide">
        <div class="col-md-8">
            @foreach( $postsFeatured as $featured)

                @if($loop->first)
                    <article class="img-big">
                        <a href="{{ url("/tutorial/{$featured->url}") }}" title=" {{$featured->title}}">
                            <img src="{{url("assets/uploads/posts/{$featured->image}")}}"
                                 alt="{{$featured->name}}"
                                 class="img-slide-big">
                            <h1 class="text-slide">
                                {{$featured->title}}
                            </h1>
                        </a>
                    </article>
                @else
                    <article class="img-small col-md-12 col-sm-6 col-xm-12">
                        <a href="{{ url("/tutorial/{$featured->url}") }}" title=" {{$featured->title}}">
                            <img src="{{url("assets/uploads/posts/{$featured->image}")}}"
                                 alt="{{$featured->name}}"
                                 class="img-slide-small">

                            <h1 class="text-slide">
                                {{$featured->title}}
                            </h1>
                        </a>
                    </article>
                @endif

                @if($loop->first)
        </div>
        <div class="col-md-4">
            @endif
            @endforeach
        </div>
    </div><!--Slide-->


    <section class="content">
        <div class="col-md-8">

            @forelse($posts as $post)
                <article class="post">
                    <div class="image-post col-md-4 text-center">
                        <img src="{{url("assets/uploads/posts/{$post->image}")}}" alt="{{$post->title}}" class="img-post">
                    </div>
                    <div class="description-post col-md-8">
                        <h2 class="title-post">{{$post->title}}</h2>

                        <p class="description-post">
                            {!! Str::limit($post->description, 200) !!}
                        </p>

                        <a class="btn-post" href="{{ url("/tutorial/{$post->url}") }}">Ir <span
                                class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </article>
            @empty
                <p>Nenhum post encontrado</p>
            @endforelse

            <div class="pagination-posts">
                {!! $posts->links() !!}
            </div>

        </div><!--POSTS-->

            @include('site.includes.sidebar')

    </section>
@endsection

@extends('layouts.app')

@section('content')
  <div class="col-md-8 blog-main">
    <h1>
      {{ $post->title }}
    </h1>
    {{ $post->body }}

    <hr />

    <div class="comments">
      <ul class="list-group">
        @foreach ($post->comments as $comment)
          <li class="list-group-item">
            <strong>
              {{ $comment->created_at->diffForHumans() }}: &nbsp;
            </strong>
            {{ $comment->body }}
          </li>
        @endforeach
      </ul>
    </div>

    {{-- Add a comment --}}
    <hr />

    @if (Auth::check())
      <p>
        Comment as {{ Auth::user()->name }}
      </p>
      <div class="card-block">
        <form method="post" action="/post/{{ $post->id }}/comments">
          {{ csrf_field() }}
          <div class="form-group">
            <textarea name="body" placeholder="Tvůj komentář" class="form-control" required></textarea>
          </div>

          <div class="form-group">
              <button type="submit" class="btn btn-primary">Add comment</button>
          </div>
        </form>
        @include('layouts.errors')
      </div>
    @endif

  </div>
@endsection

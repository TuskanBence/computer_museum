@extends('layouts.app')
@section('title', 'View item: ')

@section('content')
    <div class="container">
        @if (Session::has('comment_created'))
            <div class="alert alert-success">
               You succesfuly commented
            </div>
        @endif
        @if (Session::has('comment_deleted'))
            <div class="alert alert-success">
                You succesfuly deleted your comment
            </div>
        @endif
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>{{ $item->name }}</h1>
                <p class="small text-secondary mb-0">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $item->obtained }}</span>
                </p>

                <div class="mb-2">
                    @foreach ($item->labels as $label)
                        @if ($label->display == true)
                            <a href="{{ route('labels.show',$label) }}" class="text-decoration-none">
                                <span style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
                <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
            </div>
            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    @can('update', $item)
                        <a role="button" class="btn btn-sm btn-primary" href="{{ route('items.edit', $item) }}"><i
                                class="far fa-edit"></i> Edit
                            item</a>
                    @endcan
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i
                            class="far fa-trash-alt">
                            <span></i> Delete item</span>
                    </button>

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete item <strong>{{ $item->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete-item-form').submit();">
                            Yes, delete this item
                        </button>
                        <form id="delete-item-form" action="{{ route('items.destroy', $item) }}" method="POST"
                            class="d-none">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <img src="{{ asset(isset($item->image) ? 'storage/' . $item->image : 'images/default_post_cover.jpg') }}"
            class="card-img-top" alt="Post cover">

        <div class="mt-3 border border-secondary">
            <h4>Item's description: </h4><p>{{ $item->description }}</p>
        </div>
        <div class="mt-3 border border-warning">
            @forelse ($comments as $comment)
                <div class="border border-bottom">
                    <b>Author: {{ $comment->user->name }}</b>
                    <span><a href='#'>Edit</a></span>
                    <button type="button" class="btn btn-danger"
                        onclick="document.getElementById('delete-comment-form').submit();">
                        Delete
                    </button>
                    <span>{{ $comment->created_at }}</span>
                    <p>{{ $comment->text }}</p>
                    <form id="delete-comment-form" action="{{ route('comments.destroy', $comment) }}" method="POST"
                        class="d-none">
                        @method('DELETE')
                        @csrf
                    </form>
                </div>
            @empty
                <div class="alert alert-warning" role="alert">
                    No comments found!
                </div>
            @endforelse
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <div class="form-group row mb-3">
                    <label for="text" class="col-sm-2 col-form-label">Comment</label>
                    <div class="col-sm-10">
                        <textarea rows="5" class="form-control @error('text') is-invalid @enderror" id="text" name="text">{{ old('text') }}</textarea>
                        @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <input type="hidden" name="item_id" value="{{ $item->id }}" />
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Add Comment" />
                    </div>
            </form>
        </div>
    </div>
@endsection

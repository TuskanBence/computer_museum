@extends('layouts.app')
@section('title', 'Create item')

@section('content')
<div class="container">
    <h1>Create item</h1>
    <div class="mb-4">
        {{-- TODO: Link --}}
        <a href="{{route('items.index')}}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
    </div>

    @if (Session::has('item_created'))
    <div class="alert alert-success">
       You succesfuly created a new item {{ session()->get('item_created')}}
    </div>

    @endif
    @auth
        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="text" class="col-sm-2 col-form-label">Description*</label>
                <div class="col-sm-10">
                    <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="obtain" class="col-sm-2 col-form-label">Obtained*</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control @error('obtained') is-invalid @enderror" id="obtained" name="obtained" value="{{ old('obtained') }}">
                    @error('obtained')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="label" class="col-sm-2 col-form-label py-0">Labels</label>
                <div class="col-sm-10">
                    @forelse ($labels as $label)
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                value="{{ $label->id }}"
                                id="label{{ $label->id }}"
                                @checked( in_array($label->id,old('labels',[])))
                                name="labels[]"
                            >
                            <label for="label{{ $label->id }}" class="form-check-label">
                                <span style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span>
                            </label>
                        </div>
                    @empty
                        <p>No labels found</p>
                    @endforelse
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                    </div>
                            <div id="image_preview" class="col-12 d-none">
                                <p>Cover preview:</p>
                                <img id="image_preview_image" src="#" alt="image preview" width="300px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>
        </form>
    @endauth

</div>
@endsection

@section('scripts')
<script>
    const coverImageInput = document.querySelector('input#image');
    const coverPreviewContainer = document.querySelector('#image_preview');
    const coverPreviewImage = document.querySelector('img#image_preview_image');

    coverImageInput.onchange = event => {
        const [file] = coverImageInput.files;
        if (file) {
            coverPreviewContainer.classList.remove('d-none');
            coverPreviewImage.src = URL.createObjectURL(file);
        } else {
            coverPreviewContainer.classList.add('d-none');
        }
    }
</script>
@endsection

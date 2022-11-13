@extends('layouts.app')
@section('title', 'Create label')

@section('content')
    <div class="container">
        <h1>Create category</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        @if (Session::has('label_created'))
            <div class="alert alert-success">
                Sikeresen létrehoztad a kategóriát:
                <span style="color:white;background-color:{{ session('color') }};">{{ session('name') }}</span>
            </div>
        @endif


        {{-- TODO: Session flashes --}}

        {{-- TODO: action, method --}}
        <form method="POST" action="{{ route('labels.store') }}">
            @csrf
            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Color*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('color') is-invalid @enderror" id="color"
                        name="color" value="{{ old('color') }}">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Do you want to display it?</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-check-input @error('display') is-invalid @enderror"
                            id="display" name="display" @checked(old('display')) value="checked">
                        @error('display')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>

        </form>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Edit label')

@section('content')
    <div class="container">
        <h1>Create category</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('labels.show',$label) }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        @if (Session::has('label_edited'))
            <div class="alert alert-success">
                Sikeresen megváltoztatta a labelt:
                <span style="color:white;background-color:{{ session('color') }};">{{ session('name') }}</span>
            </div>
        @endif


        <h1>Original label: <span style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span></h1>
        <form method="POST" action="{{ route('labels.update',$label) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{old('name') ? old('name') : $label->name}}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Color*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('color') is-invalid @enderror" id="color"
                        name="color" value="{{old('color') ? old('color') : $label->color}}">
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

@extends('layouts.admin')

@section('title', __('category.Edit_Category'))
@section('content-header', __('category.Edit_Category'))
@section('content-actions')
<a href="{{route('category.index')}}" class="btn btn-primary">{{ __('category.Category_List') }}</a>
@endsection
@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('category.update', $category) }}" method="POST" >
            @csrf
            @method('PUT')            

            <div class="form-group">
                <label for="name">{{ __('category.Name') }}</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="{{ __('category.Name') }}" value="{{ old('name', $category->category_name) }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>            

            <div class="form-group">
                <label for="status">{{ __('category.Status') }}</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                    <option value="1" {{ old('status', $category->status) === 1 ? 'selected' : ''}}>{{ __('common.Active') }}</option>
                    <option value="0" {{ old('status', $category->status) === 0 ? 'selected' : ''}}>{{ __('common.Inactive') }}</option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <input type="hidden" name="client_id" value="ISPPOS">
            <button class="btn btn-primary" type="submit">{{ __('common.Update') }}</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection
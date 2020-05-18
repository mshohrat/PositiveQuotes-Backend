@extends('layouts.app')

@section('content')

    @if (isset($profile))
    <div class="container">
    <form>
        <div class="form-group row">
            <label for="id" class="col-sm-2 col-form-label"><strong>ID</strong></label>
            <div class="col-sm-6">
                <input type="text" readonly class="form-control-plaintext text-primary list-group-item-secondary text-center" id="id" value="{{ $profile->user_id }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label"><strong>Name :</strong></label>
            <div class="col-sm-6">
                <input type="text" readonly class="form-control-plaintext text-primary list-group-item-secondary text-center" id="name" value="{{ $profile->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label"><strong>Email :</strong></label>
            <div class="col-sm-6">
                <input type="text" readonly class="form-control-plaintext text-primary list-group-item-secondary text-center" id="email" value="{{ $profile->email }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="gender" class="col-sm-2 col-form-label"><strong>Gender :</strong></label>
            <div class="col-sm-6">
                <input type="text" readonly class="form-control-plaintext text-primary list-group-item-secondary text-center" id="gender"
                       value="@switch($profile->gender)
                           @case(\App\Profile::GENDER_MAIL)Mail @break
                           @case(\App\Profile::GENDER_WOMAN)Woman @break
                           @default()Unknown @break
                           @endswitch">
            </div>
        </div>
    </form>
    </div>

    @else

    <div class="container align-content-center">
        <h2>User profile not found!!</h2>
    </div>

    @endif

@endsection

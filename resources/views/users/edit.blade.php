@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Edit User',
    'activePage' => 'users',
    'activeNav' => '',
])

@section('content')
    <div class="panel-header">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit User') }}</h3>
                            </div>
                            <div class="col-4 text-right">
{{--                                @switch($lastListName)--}}
{{--                                    @case('Active Users')--}}
{{--                                        <a href="{{ route('user.active_users') }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>--}}
{{--                                    @break--}}
{{--                                    @case('Inactive Users')--}}
{{--                                        <a href="{{ route('user.inactive_users') }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>--}}
{{--                                    @break--}}
{{--                                    @default--}}
{{--                                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>--}}
{{--                                    @break--}}
{{--                                @endswitch--}}
                                <a href="{{ url()->previous() }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('user.update', $user) }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $user->name) }}"  required autofocus>

                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', $user->email) }}" required>
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                                <div class="form-group py-sm-2">
                                    <div class="form-check">
                                        <label class="form-check-label" for="is_active">
                                            <input name="is_active"  class="form-check-input" type="checkbox" id="is_active" @if ($user->is_active == 1) checked @endif value="{{ old('is_active', $user->is_active) }}">
                                            <span class="form-check-sign">{{ __('Is Active') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <div class="form-check" data-toggle="collapse" href="#update_password_collapse">
                                        <label class="form-check-label" for="update_password">
                                            <input  class="form-check-input" type="checkbox" id="update_password">
                                            <span class="form-check-sign">{{ __('Update Password') }}</span>
                                        </label>
                                    </div>
{{--                                    <div class="ui-1_check" data-toggle="collapse" href="#users">--}}
{{--                                        <p class="px-2">--}}
{{--                                            {{ __("Users") }}--}}
{{--                                            <b class="caret"></b>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
                                    <div class="collapse" id="update_password_collapse">
                                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} py-sm-2">
                                            <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                            <input type="password" name="password" id="input-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="">

                                            @include('alerts.feedback', ['field' => 'password'])
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                            <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

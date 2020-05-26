@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Create Quote',
    'activePage' => 'quotes',
    'activeNav' => '',
])

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Create Quote') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ url()->previous() }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('quote.store') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Quote information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('text') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-text">{{ __('Name') }}</label>
                                    <input type="text" name="text" id="input-text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Text') }}" value="{{ old('text') }}" required autofocus>

                                    @include('alerts.feedback', ['field' => 'text'])
                                </div>
                                <div class="form-group{{ $errors->has('author') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-author">{{ __('Author') }}</label>
                                    <input type="text" name="author" id="input-author" class="form-control{{ $errors->has('author') ? ' is-invalid' : '' }}" placeholder="{{ __('Author') }}" value="{{ old('author') }}">

                                    @include('alerts.feedback', ['field' => 'author'])
                                </div>
                                <div class="form-group py-sm-2">
                                    <div class="form-check">
                                        <label class="form-check-label" for="active">
                                            <input name="active"  class="form-check-input" type="checkbox" id="active" checked value="{{ old('active') }}">
                                            <span class="form-check-sign">{{ __('Is Verified') }}</span>
                                        </label>
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

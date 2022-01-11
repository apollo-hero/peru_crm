@extends('provider.layout.auth')

<!-- Main Content -->
@section('content')

  
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form role="form" method="POST" action="{{ url('/provider/password/email') }}">
        {{ csrf_field() }}

        <div class="col-md-12">
            <input type="email" class="form-control" name="email" placeholder="@lang('provider.signup.email_address')" value="{{ old('email') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif                        
        </div>

        <div class="col-md-12">
            <button class="log-teal-btn" type="submit">@lang('provider.signup.send_password_reset_link')</button>
        </div>
    </form>     


@endsection



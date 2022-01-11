@extends('provider.layout.auth')

@section('content')

<div class="col-md-12">
    <form role="form" method="POST" action="{{ url('/provider/password/reset') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="@lang('user.profile.email')" autofocus>

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

        <input id="password" type="password" class="form-control" name="password" placeholder="@lang('provider.signup.password')">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirma Password">

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
        
        <br>

        <button type="submit" class="log-teal-btn">
            RESETEAR PASSWORD
        </button>
         
    </form>
    
    <p class="helper">O <a href="{{url('provider/login')}}">Inicia Sessión</a> con tu cuenta.</p>   
    
</div>
@endsection

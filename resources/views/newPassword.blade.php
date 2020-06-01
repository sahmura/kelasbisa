@extends('layouts.home')

@section('page-header')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('setNewPassword') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $dataUser->id }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}" required autocomplete="password" autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span id="errorMessage2" class="text-danger">Password minimal 8 karakter</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Repeat New Password') }}</label>

                            <div class="col-md-6">
                                <input id="repassword" type="password"
                                    class="form-control @error('repassword') is-invalid @enderror" name="repassword"
                                    value="{{ old('repassword') }}" required autocomplete="repassword" autofocus>

                                @error('repassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span id="errorMessage" class="text-danger">Password tidak sesuai</span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btnSubmit">
                                    {{ __('Reset') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Have an account?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    @if(session('success'))
    Swal.fire({
        title: "{{ session('success') }}",
        icon: 'success'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        title: "{{ session('error') }}",
        icon: 'error'
    });
    @endif

    $(document).ready(function () {
        $('#errorMessage').hide();
    });

    $('#repassword').on('keyup', function () {
        if ($('#password').val() != $('#repassword').val()) {
            $('#errorMessage').show();
            $('#btnSubmit').prop('disabled', true);
        } else {
            $('#errorMessage').hide();
            $('#btnSubmit').prop('disabled', false);
        }
    });

    $('#password').on('keyup', function () {
        if ($(this).val().length < 8) {
            $('#errorMessage2').show();
            $('#btnSubmit').prop('disabled', true);
        } else {
            $('#errorMessage2').hide();
            $('#btnSubmit').prop('disabled', false);
        }
    });

</script>
@endpush

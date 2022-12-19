@extends('index')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Reset Password</h1>
    </div>
    <!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($status == 'User')
                    <form action="{{ route('resetPassword', $id) }}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Password Baru</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan Password Baru">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <button type="submit" class="btn btn-md btn-primary mt-3">SAVE</button>
                            </div>
                        </div>
                    </form>
                    @else <p>{{ $status }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
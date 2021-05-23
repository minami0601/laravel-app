@if (count($errors) > 0)
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if (session('flash_message'))
    <div class="alert alert-info">
        {{ session('flash_message') }}
    </div>
@endif
@if (session('flash_danger'))
    <div class="alert alert-danger">
        {{ session('flash_danger') }}
    </div>
@endif
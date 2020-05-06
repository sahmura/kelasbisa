<div class="{{ $class }}">
    <div class="card shadow">
        <img class="card-img-top" src="{{ url('cover/' . $cover) }}?" alt="Card image cap">
        <div class="card-body">
            <h2>{{ $name }}</h2>
            <p>{{ $speakers }}</p>
            <p>{!! $description !!}</p>
        </div>
    </div>
</div>

<div class="{{ $class }}">
    <div class="card shadow">
        <img class="card-img-top" src="{{ url('cover/' . $cover) }}" alt="Card image cap">
        <div class="card-body">
            <h5>{{ $name }}</h5>
            <p>{{ $speakers }}</p>
            <p>{!! $description !!}</p>
        </div>
    </div>
</div>
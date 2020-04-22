<div class="{{ $class }}">
    <div class="card card-profile">
        <img src="{{ $bgimage }}" alt="Image placeholder" class="card-img-top">
        <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                    <a href="#">
                        <img src="{{ $userimg }}" class="rounded-circle">
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col">
                    <div class="card-profile-stats d-flex justify-content-center">
                        <div>
                            <span class="heading">22</span>
                            <span class="description">Friends</span>
                        </div>
                        <div>
                            <span class="heading">10</span>
                            <span class="description">Photos</span>
                        </div>
                        <div>
                            <span class="heading">89</span>
                            <span class="description">Comments</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <h5 class="h3">
                    {{ $name }}<span class="font-weight-light"></span>
                </h5>
                <div class="h5 font-weight-300">
                    <i class="ni location_pin mr-2"></i>{{ $email }}
                </div>
                <div>
                    <i class="ni education_hat mr-2"></i>{{$description}}
                </div>
            </div>
        </div>
    </div>
</div>

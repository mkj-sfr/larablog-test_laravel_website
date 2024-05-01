<div class="main-banner header-text">
    <div class="container-fluid">
      <div class="owl-banner owl-carousel">
        @foreach ($blogs as $blog)
        @php
        $date = Illuminate\Support\Carbon::parse($blog->updated_at)
    @endphp
        
        <div class="item">
          <img src="{{$blog->image ? $blog->image : asset('images/banner-item-01.jpg')}}" alt="">
          <div class="item-content">
            <div class="main-content">
              <div class="meta-category">
                <a href=""><span>{{$blog->category()->first()->name}}</span></a>
              </div>
              <a href="/blogs/{{$blog->id}}"><h4>{{$blog->title}}</h4></a>
              <ul class="post-info">
                <li><a href="/blogs?name={{$blog->user()->first()->last_name}}">{{$blog->user()->first()->first_name . ' ' . $blog->user()->first()->last_name}}</a></li>
                <li class="text-white">{{$date->englishMonth . ' ' . $date->day . ', ' . $date->year}}</li>
                <li class="text-white">{{$blog->comments()->count()}} Comments</li>
              </ul>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
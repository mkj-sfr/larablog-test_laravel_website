<div class="post-options">
    <div class="row">
      <div class="col-6">
        <ul class="post-tags">
          <li><i class="fa fa-tags"></i></li>
          @foreach (explode(',', $tags) as $tag)
          <li><a href="/blogs?tags={{$tag}}">{{$tag}}</a> </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
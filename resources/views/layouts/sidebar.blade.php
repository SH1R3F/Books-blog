<div class="col-lg-3 sidebar text-right">
  @if(count((new \App\Http\Controllers\CategoriesController)->sidebarCategories()))
    <!-- Widget -->
    <div class="widget">
      <h5 class="widget-title">أقسام المكتبة</h5>
      <div class="widget-content">
        <ul>
          @foreach((new \App\Http\Controllers\CategoriesController)->sidebarCategories() as $category)
            <a href="{{route('category.show', $category->slug)}}">
              <li>
                <span>{{$category->title}}</span>
                <i class="fa fa-book"></i>
              </li>
            </a>
          @endforeach
          <a href="{{route('category.index')}}">
            <li>
              <span>كل الأقسام</span>
              <i class="fa fa-book"></i>
            </li>
          </a>
        </ul>
      </div>
    </div><!-- Widget -->
  @endif

  @if(count((new \App\Http\Controllers\AuthorsController)->sidebarAuthors()))
    <!-- Widget -->
    <div class="widget">
      <h5 class="widget-title">المؤلفون</h5>
      <div class="widget-content">
        <ul>
          @foreach((new \App\Http\Controllers\AuthorsController)->sidebarAuthors() as $author)
            <a href="{{route('author.show', $author->slug)}}">
              <li>
                <span>{{$author->author_name}}</span>
                <i class="fa fa-book"></i>
              </li>
            </a>
          @endforeach
          <a href="{{route('author.index')}}">
            <li>
              <span>كل المؤلفين</span>
              <i class="fa fa-book"></i>
            </li>
          </a>
        </ul>
      </div>
    </div><!-- Widget -->
  @endif

  @if(count((new \App\Http\Controllers\TagsController)->sidebarTags()))
    <!-- Widget -->
    <div class="widget">
      <h5 class="widget-title">العلامات</h5>
      <div class="widget-content">
        <ul>
          @foreach((new \App\Http\Controllers\TagsController)->sidebarTags() as $tag)
            <a href="{{route('tag.show', $tag->slug)}}">
              <li>
                <span>{{$tag->title}}</span>
                <i class="fa fa-book"></i>
              </li>
            </a>
          @endforeach
          <a href="{{route('tag.index')}}">
            <li>
              <span>كل العلامات</span>
              <i class="fa fa-book"></i>
            </li>
          </a>
        </ul>
      </div>
    </div><!-- Widget -->
  @endif
</div>

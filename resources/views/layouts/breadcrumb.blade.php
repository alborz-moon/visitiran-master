<nav aria-label="breadcrumb" style="display: flex;justify-content:space-between;">
    <ol class="breadcrumb">
        <?php $i = 1; ?>
        @foreach($product['parentPath'] as $path)
            <li class="breadcrumb-item">
                @if($i != count($product['parentPath']))
                    <a href="{{route('single-category', ['category' => $path['id'], 'slug' => $path['slug']])}}" class="colorBlack btnHover">{{ $path['name'] }}</a>
                @else
                    <a class="colorBlack btnHover">{{ $path }}</a>
                @endif
            </li>
            <?php $i++; ?>
        @endforeach
    </ol>
    @include('shop.product.bookmark')
</nav>
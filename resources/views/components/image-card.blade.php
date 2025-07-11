<div class="image-card" onclick="getFileInfo('{{$image['directory']}}', '{{$image['fullname']}}')"
     data-name="{{ $image['name'] }}"
     data-size="{{ $image['size'] }}"
     data-directory="{{ $image['directory'] }}"
     data-usage="{{ $image['usage_count'] }}">
    <img loading="lazy" src="{{ asset($image['path']) }}" alt="{{ $image['name'] }}" class="image-preview">
    <div class="image-info">
        <div class="image-name" title="{{ $image['name'] }}">{{ $image['name'] }}</div>
        <div class="directory">
            <i class="fa-solid fa-folder"></i> 
            {{ $image['directory'] }}
        </div>
        <div class="image-details">
            <div class="detail-item">
                <i class="fa-solid fa-database"></i>
                <span>{{ number_format($image['size'] / 1024 / 1024, 2) }} MB</span>
            </div>
            <div class="detail-item">
                <i class="fa-solid fa-recycle"></i>
                <span>{{ $image['usage_count'] }} uses</span>
            </div>
        </div>
        @if (!empty($image['uniqid']))
            <div class="detail-item">
                <i class="fa-solid fa-hashtag"></i>
                <span>{{ $image['uniqid'] }}</span>
            </div>
        @endif
    </div>
    <span class="file-type-badge">{{ pathinfo($image['name'], PATHINFO_EXTENSION) }}</span>
    <span class="usage-badge {{ $image['usage_count'] == 0 ? 'no-usage' : '' }}">
        {{ $image['usage_count'] }} uses
    </span>
</div>

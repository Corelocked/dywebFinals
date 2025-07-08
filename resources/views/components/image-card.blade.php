<div class="image-card" onclick="getFileInfo('{{$image['directory']}}', '{{$image['fullname']}}')"
     data-name="{{ $image['name'] }}"
     data-size="{{ $image['size'] }}"
     data-directory="{{ $image['directory'] }}"
     data-usage="{{ $image['usage_count'] }}">
    <img loading="lazy" src="{{ asset($image['path']) }}" alt="{{ $image['name'] }}" class="image-preview">
    <div class="image-info">
        <div class="image-name" title="{{ $image['name'] }}">{{ $image['name'] }}</div>
        <div class="image-details">
            <span class="image-size">{!! formatBytes($image['size']) !!}</span>
            <span class="image-usage">{{ $image['usage_count'] }} uses</span>
        </div>
    </div>
    <div class="image-badge">
        <i class="fas fa-{{ pathinfo($image['name'], PATHINFO_EXTENSION) === 'jpg' || pathinfo($image['name'], PATHINFO_EXTENSION) === 'jpeg' ? 'image' : (pathinfo($image['name'], PATHINFO_EXTENSION) === 'png' ? 'file-image' : 'file') }}"></i>
    </div>
</div>
    <div class="info">
        <div class="info-header">
            <p class="directory">
                <i class="fa-solid fa-folder"></i> 
                {{ $image['directory'] }}
            </p>
            <div class="usage-indicator {{ $image['usage_count'] > 0 ? 'in-use' : 'unused' }}">
                <i class="fa-solid fa-{{ $image['usage_count'] > 0 ? 'check-circle' : 'exclamation-triangle' }}"></i>
            </div>
        </div>
        <p class="filename" title="{{ $image['name'] }}">{{ $image['name'] }}</p>
        @if (!empty($image['uniqid']))
            <p class="uniqid"><i class="fa-solid fa-hashtag"></i> {{ $image['uniqid'] }}</p>
        @endif
        <div class="file-stats">
            <div class="stat-item">
                <i class="fa-solid fa-database"></i>
                <span>{!! formatBytes($image['size']) !!}</span>
            </div>
            <div class="stat-item">
                <i class="fa-solid fa-recycle"></i>
                <span>{{ $image['usage_count'] }} uses</span>
            </div>
        </div>
    </div>
</div>

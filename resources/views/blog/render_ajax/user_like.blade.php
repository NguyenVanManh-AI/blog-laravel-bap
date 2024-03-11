<div id="my_like_{{ $id_article }}" class="avatar_user_like">
    @if (\Illuminate\Support\Str::startsWith(auth()->guard('user')->user()->avatar, 'http'))
        <img alt="Avatar" src="{{ auth()->guard('user')->user()->avatar }}">
    @else
        <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . auth()->guard('user')->user()->avatar }}">
    @endif
</div>
@foreach ($users as $index => $user)
<tr>
    <th scope="row">{{ $users->perPage() * ($users->currentPage() - 1) + $index + 1 }}</th>
    <td>
        <div class="cell1">
            <div>
                @if (\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
                    <img src="{{ $user->avatar }}">
                @else
                    <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}">
                @endif
            </div>
            <div>
                <p class="m-0 p-0 name-user"><a href="{{ route('main.personal_page', ['id_user' => $user->id]) }}">{{$user->name}}</a></p>
                <p class="m-0 p-0" style="color:gray">{{$user->username}}</p>
            </div>
        </div>
    </td>
    <td>{{$user->email}}</td>
    <td style="padding-left: 0px;">
        <div class="big-toggle" >
            <div class="button2 r button-6">
                @if($user->status == 0)
                <input data-id_user="{{$user->id}}" checked type="checkbox" class="checkbox" />
                @else 
                <input data-id_user="{{$user->id}}" type="checkbox" class="checkbox" />
                @endif
                <div class="knobs"></div>
                <div class="layer"></div>
            </div>
        </div>
    </td>
</tr>
@endforeach
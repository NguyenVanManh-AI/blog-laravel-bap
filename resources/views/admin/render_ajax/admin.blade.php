@foreach ($admins as $index => $admin)
<tr>
    <th scope="row">{{ $admins->perPage() * ($admins->currentPage() - 1) + $index + 1 }}</th>
    <td>
        <div class="cell1">
            <div>
                <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $admin->avatar }}">
            </div>
            <div>
                <p class="p-0 m-0">{{$admin->name}}</p>
                <p class="p-0 m-0" style="color:gray">{{$admin->created_at}}</p>
            </div>
        </div>
    </td>
    <td>{{$admin->email}}</td>
    <td>
        @if($admin->id != auth()->guard('admin')->user()->id)
            @if($admin->role == 0 || auth()->guard('admin')->user()->role == 2)
            <select id="change_admin_{{$admin->id}}" data-id_admin="{{$admin->id}}" class="role-admin form-control form-control-sm">
                <option value="1" {{ $admin->role == 1 ? 'selected' : '' }}>Super Admin</option>
                <option value="0" {{ $admin->role == 0 ? 'selected' : '' }}>Admin</option>
            </select>
            @else
                @if($admin->role == 1)
                    Super Admin
                @else 
                    Manager
                @endif
            @endif
        @else
            @if($admin->role == 1)
                Super Admin
            @else 
                Manager
            @endif
        @endif
    </td>
    <td>
        @if($admin->id != auth()->guard('admin')->user()->id)
            @if($admin->role == 0 || auth()->guard('admin')->user()->role == 2)
            <form id="del_admin_{{$admin->id}}" id="del_admin_{{$admin->role}}" method="POST" action="{{ route('admin.delete_admin', $admin->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this admin ?');">
                @csrf
                <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i>
                    Delete</button>
            </form>
            @endif
        @endif
    </td>
</tr>
@endforeach
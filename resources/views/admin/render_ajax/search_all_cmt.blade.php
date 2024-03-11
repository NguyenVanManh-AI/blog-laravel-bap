@foreach ($comments as $index => $comment)
<tr>
    <th>{{ $comments->perPage()*($comments->currentPage() -1) + $index + 1 }}</th>
    <td>{{ \Illuminate\Support\Str::limit($comment->content, 69, '...') }}</td>
    <td>{{ $comment->name }}</td>
    <td>
        <form method="POST" action="{{ route('admin.delete_comment', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment ?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> Delete</button>
        </form>
    </td>
</tr>
@endforeach
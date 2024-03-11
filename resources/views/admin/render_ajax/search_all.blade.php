@foreach ($articles as $index => $article)
<tr>
    <th>{{ $articles->perPage()*($articles->currentPage() -1) + $index + 1 }}</th>
    <td>{{ \Illuminate\Support\Str::limit($article->title, 69, '...') }}</td>
    <td>{{ $article->name }}</td>
    <td>
        <a href="{{ route('admin.show', ['id' => $article->id]) }}" class="btn btn-outline-primary">
            <i class="fa-solid fa-eye"></i> View
        </a>
    </td>
    <td>
        <form method="POST" action="{{ route('admin.delete_article', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> Delete</button>
        </form>
    </td>
</tr>
@endforeach
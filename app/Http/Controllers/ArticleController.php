<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestArticle;
use App\Models\User;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * getTitle
     *
     * @param string $title_main
     * @param string $title_sub
     * @return array
     */
    public function getTitle($titleMain, $titleSub)
    {
        $title['title_main'] = $titleMain;
        $title['title_sub'] = $titleSub;

        return $title;
    }

    /**
     * all
     *
     * @return object
     */
    public function allArticle()
    {
        $articles = $this->articleService->allArticle();

        return view('blog.article.index', ['articles' => $articles, 'title' => $this->getTitle('Articles', 'All Articles')]);
    }

    /**
     * showDetail
     *
     * @param int $id
     * @return object
     */
    public function showDetail($id)
    {
        $article = $this->articleService->showDetail($id);

        return view('blog.article.detail_article', ['article' => $article, 'title' => $this->getTitle('Articles', 'Details Articles')]);
    }

    /**
     * showDetailAdmin
     *
     * @param int $id
     * @return object
     */
    public function showDetailAdmin($id)
    {
        $article = $this->articleService->showDetail($id);

        return view('admin.manage.detail_article', ['article' => $article, 'title' => $this->getTitle('Articles', 'Details Articles')]);
    }

    /**
     * showAdd
     *
     * return view
     */
    public function showAdd(Request $request)
    {
        return view('blog.article.add_article', ['title' => $this->getTitle('Articles', 'Add Articles')]);
    }

    /**
     * showEdit
     *
     * @param int $id
     * @return object
     */
    public function showEdit(Request $request, $id)
    {
        $article = $this->articleService->showDetail($id);

        return view('blog.article.edit_article', ['article' => $article, 'title' => $this->getTitle('Articles', 'Update Articles')]);
    }

    /**
     * myArticle
     *
     * @return view
     */
    public function myArticle(Request $request)
    {
        $user = Auth::guard('user')->user();
        $articles = $this->articleService->myArticle($user->id);

        return view('blog.article.my_article', ['articles' => $articles, 'title' => $this->getTitle('Articles', 'My Articles')]);
    }

    /**
     * addArticle
     *
     * @param RequestArticle $request
     * @return object
     */
    public function addArticle(RequestArticle $request)
    {
        $input = (object) [
            'id_user' => Auth::guard('user')->user()->id ?? '',
            'title' => $request->title ?? '',
            'content' => $request->content ?? '',
        ];

        return $this->articleService->addArticle($input);
    }

    /**
     * updateArticle
     *
     * @param RequestArticle $request
     * @return object
     */
    public function updateArticle(RequestArticle $request)
    {
        $input = (object) [
            'id_article' => $request->id ?? '',
            'title' => $request->title ?? '',
            'content' => $request->content ?? '',
        ];

        return $this->articleService->updateArticle($input);
    }

    /**
     * deleteArticle
     *
     * @param int $id
     * @return object
     */
    public function deleteArticle(Request $request, $id)
    {
        return $this->articleService->deleteArticle($id);
    }

    /**
     * deleteArticleAdmin
     *
     * @param int $id
     * @return object
     */
    public function deleteArticleAdmin(Request $request, $id)
    {
        return $this->articleService->deleteArticleAdmin($id);
    }

    /**
     * ajaxSearch
     *
     * @param Request $request
     * @return object
     */
    public function ajaxSearch(Request $request)
    {
        return $this->articleService->ajaxSearch($request->search);
    }

    /**
     * ajaxSearch
     *
     * @param Request $request
     * @return object
     */
    public function ajaxSearchAdmin(Request $request)
    {
        return $this->articleService->ajaxSearchAdmin($request->search);
    }

    /**
     * ajaxSearchMy
     *
     * @param Request $request
     * @return object
     */
    public function ajaxSearchMy(Request $request)
    {
        return $this->articleService->ajaxSearchMy($request->search);
    }

    // Admin
    /**
     * allArticleAdmin
     *
     * @return object
     */
    public function allArticleAdmin()
    {
        $articles = $this->articleService->allArticle();
        $nameUsers = User::all();

        return view('admin.manage.article', ['nameUsers' => $nameUsers, 'articles' => $articles, 'title' => $this->getTitle('Articles', 'All Articles')]);
    }
}

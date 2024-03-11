<?php

namespace App\Services;

use App\Repositories\ArticleInterface;
use App\Repositories\CommentRepository;
use App\Repositories\LikedRepository;
use App\Repositories\NotifyRepository;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleService
{
    protected ArticleInterface $articleRepository;

    /**
     * __construct
     */
    public function __construct(
        ArticleInterface $articleRepository
    ) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * allArticle
     *
     * @return object
     */
    public function allArticle()
    {
        return $this->articleRepository->getListArticle()->paginate(6);
    }

    /**
     * showDetail
     *
     * @param int $id
     * @return object
     */
    public function showDetail($id)
    {
        return $this->articleRepository->getArticleDetail($id);
    }

    /**
     * myArticle
     *
     * @param int $id
     * @return object
     */
    public function myArticle($id)
    {
        return $this->articleRepository->getMyArticle($id)->paginate(6);
    }

    /**
     * addArticle
     *
     * @param object $input
     * @return object
     */
    public function addArticle($input)
    {
        try {
            $this->articleRepository->addArticle($input);
            Toastr::success('Thêm bài viết thành công!');
            Cache::forget('articles');

            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error('Thêm bài viết thất bại!');

            return redirect()->back()->withInput();
        }
    }

    /**
     * updateArticle
     *
     * @param object $input
     * @return object
     */
    public function updateArticle($input)
    {
        $user = Auth::guard('user')->user();
        $article = $this->articleRepository->getArticleDetail($input->id_article);
        if ($user->id != $article->id_user) {
            Toastr::error('Bạn không có quyền chỉnh sửa bài viết này !');

            return redirect()->back()->withInput();
        }
        try {
            $this->articleRepository->updateArticle($input);
            Toastr::success('Cập nhật bài viết bài viết thành công!');
            Cache::forget('articles');

            return redirect()->back()->withInput();
        } catch (Exception $e) {
            Toastr::error('Cập nhật bài viết bài viết thất bại!');

            return redirect()->back()->withInput();
        }
    }

    /**
     * deleteArticle
     *
     * @param int $id
     * @return object
     */
    public function deleteArticle($id)
    {
        try {
            $user = Auth::guard('user')->user();
            $article = $this->articleRepository->getArticleDetail($id);
            if ($user->id == $article->id_user) {
                $article->delete();
                CommentRepository::deleteCommentArticle($article->id);
                LikedRepository::deleteLiked($article->id);
                NotifyRepository::deleteNotify($article->id);
                Toastr::success('Xóa bài viết thành công !');
                Cache::forget('articles');

                return redirect()->back();
            } else {
                Toastr::error('Bạn không có quyền xóa bài viết !');

                return redirect()->back();
            }
        } catch (Exception $e) {
            Toastr::error('Xóa bài viết thất bại!');

            return redirect()->back()->withInput();
        }
    }

    /**
     * deleteArticleAdmin
     *
     * @param int $id
     * @return object
     */
    public function deleteArticleAdmin($id)
    {
        try {
            $article = $this->articleRepository->getArticleDetail($id);
            $article->delete();
            CommentRepository::deleteCommentArticle($article->id);
            LikedRepository::deleteLiked($article->id);
            NotifyRepository::deleteNotify($article->id);
            Toastr::success('Xóa bài viết thành công !');
            Cache::forget('articles');

            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error('Xóa bài viết thất bại!');

            return redirect()->back()->withInput();
        }
    }

    /**
     * ajaxSearch
     *
     * @param string $search_text
     * @return response
     */
    public function ajaxSearch($searchText)
    {
        try {
            $articles = $this->articleRepository->ajaxSearch($searchText)->paginate(6);
            $renderHtml = view('blog.render_ajax.search_all', compact('articles'))->render();
            $pagination = $articles->links()->toHtml();

            return response()->json([
                'render_html' => $renderHtml,
                'pagination' => $pagination,
            ]);
        } catch (Exception $e) {
        }
    }

    /**
     * ajaxSearch
     *
     * @param string $search_text
     * @return response
     */
    public function ajaxSearchAdmin($searchText)
    {
        try {
            $articles = $this->articleRepository->ajaxSearch($searchText)->paginate(6);
            $renderHtml = view('admin.render_ajax.search_all', compact('articles'))->render();
            $pagination = $articles->links()->toHtml();

            return response()->json([
                'render_html' => $renderHtml,
                'pagination' => $pagination,
            ]);
        } catch (Exception $e) {
        }
    }

    /**
     * ajaxSearchMy
     *
     * @param string $search_text
     * @return response
     */
    public function ajaxSearchMy($searchText)
    {
        try {
            $user = Auth::guard('user')->user();
            $articles = $this->articleRepository->ajaxSearchMy($searchText, $user->id)->paginate(6);
            $renderHtml = view('blog.render_ajax.search_my', compact('articles'))->render();
            $pagination = $articles->links()->toHtml();

            return response()->json([
                'render_html' => $renderHtml,
                'pagination' => $pagination,
            ]);
        } catch (Exception $e) {
        }
    }
}

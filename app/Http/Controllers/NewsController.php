<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getNewsSmall(): View
    {
        $news = News::orderBy('created_at', 'desc')
            ->skip(0)
            ->take(6)
            ->get();

        return view('components.home.news', compact('news'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getNewsAll($slug)
    {

        // Detection des caractère dans l'url
        if (preg_match('#[0-9]#', $slug)) {

            $limit = 9;

            $news = News::where('active', 1)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->offset(($slug - 1) * $limit)
                ->get();

            $maxPage = ceil((count($news) / 9) + 1);
            $elements = array();

            for ($i = 1; $i <= (count($news) / 9) + 1; $i++) {
                array_push($elements, array($i => $i));
            }

            if (count($news) >= 1) {
                return view('blog', compact('news', 'maxPage', 'elements'));
            } else {
                return redirect()->route('blog', ['slug' => 1]);
            }
        } else {
            return redirect()->route('blog', ['slug' => 1]);
        }
    }

    public function getNewsSerch(Request $request)
    {

        $search = $request->input('search');
        $categorie = $request->input('categorie');
        $trie = $request->input('trie');

        switch ($trie) {

            case 'Les plus récent':
                $order = "DESC";
                $views = "";
                break;

            case 'Populaire':
                $order = "DESC";
                $views = "DESC";
                break;

            case 'Les plus ancien':
                $order = "ASC";
                $views = "";
                break;

            default:
                $order = "DESC";
                $views = "";
                break;
        }

        if (empty($views)) {

            $news = News::where('title', 'LIKE', '%' . $search . '%')
                ->where('categorie', 'LIKE', '%' . $categorie . '%')
                ->where('active', 1)
                ->orderBy('created_at', $order)
                ->get();
        } else {
            $news = News::where('title', 'LIKE', '%' . $search . '%')
                ->where('categorie', 'LIKE', '%' . $categorie . '%')
                ->where('active', 1)
                ->orderBy('views', $views)
                ->orderBy('created_at', $order)
                ->get();
        }

        if (count($news) >= 1) {
            return view('components.blog.search', compact('news'));
        } else {
            return response(false);
        }
    }

    public function getNewsOne($slug)
    {

        $article = News::where('url', $slug)
            ->where('active', 1)
            ->first();

        if (!empty($article->url)) {

            DB::table('news')
                ->where('url', $article->url)  // find your user by their email
                ->limit(1)  // optional - to ensure only one record is updated.
                ->update(array('views' => $article->views + 1));  // update the record in the DB.

            return view('article', compact('article'));
        } else {
            return redirect()->route('home');
        }
    }
}

<?php


namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Forums;
use Illuminate\Support\Str;
use App\Models\TopicsForums;
use Illuminate\Http\Request;
use App\Models\TopicsReplies;
use Illuminate\Support\Facades\Auth;

// require_once '../vendor/google/apiclient/autoload.php';

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
        }

        $forums = Forums::orderBy('forums.id', 'ASC')
            ->join('users', 'users.id', '=', 'forums.user_id')
            ->select('forums.*', 'users.lastname', 'users.firstname', 'users.avatar')
            ->get();

        // Get all
        $forums_topic = TopicsForums::select('id')
            ->get();

        $forums_topic_replies = TopicsReplies::select('id')
            ->get();

        if (Auth::check()) {
            return view('forum', compact('forums', 'user', 'forums_topic', 'forums_topic_replies'));
        } else {
            return view('forum', compact('forums', 'forums_topic', 'forums_topic_replies'));
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function getForum($url = null)
    {

        // Categorie du forum
        $forum_categorie = Forums::where('url', $url)
            ->first();

        if (!empty($forum_categorie)) {

            if (Auth::check()) {
                $user = User::where('id', Auth::id())->first();
            }

            // Topics all
            $topics = TopicsForums::where('forum_id', $forum_categorie->id)
                ->orderBy('topics_forums.sticky', 'desc')
                ->orderBy('topics_forums.id', 'desc')
                ->join('users', 'users.id', '=', 'topics_forums.user_id')
                ->select('topics_forums.*', 'users.lastname', 'users.firstname', 'users.avatar')
                ->get();

            $topics_replies_all = TopicsReplies::where('forum_id', $forum_categorie->id)
                ->where('status', 1)
                ->select('id')
                ->get();

            Forums::where('url', $url)
                ->update(array('views' => $forum_categorie->views + 1));

            if (Auth::check()) {
                return view('forum-categorie', compact('forum_categorie', 'topics', 'topics_replies_all', 'user'));
            } else {
                return view('forum-categorie', compact('forum_categorie', 'topics', 'topics_replies_all'));
            }
        } else {
            return redirect()->route('forum');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function getTopic($url = null)
    {

        // Topic du forum
        $forum_topic = TopicsForums::where('url', $url)
            ->join('users', 'users.id', '=', 'topics_forums.user_id')
            ->select('topics_forums.*', 'users.lastname', 'users.firstname', 'users.avatar', 'users.user_role', 'users.pays')
            ->first();

        if (!empty($forum_topic)) {

            if (Auth::check()) {
                $user = User::where('id', Auth::id())->first();
            }

            // Forums all
            $forums = Forums::orderBy('id', 'ASC')
                ->limit(6)
                ->get();

            $topics_recent = TopicsForums::orderBy('id', 'DESC')
                ->limit(6)
                ->get();

            // Categorie du forum
            $forum_categorie = Forums::where('id', $forum_topic->forum_id)
                ->first();

            // Topics all
            $topics = TopicsForums::where('forum_id', $forum_topic->forum_id)
                ->orderBy('topics_forums.id', 'ASC')
                ->join('users', 'users.id', '=', 'topics_forums.user_id')
                ->select('topics_forums.*', 'users.lastname', 'users.firstname', 'users.avatar', 'users.user_role', 'users.pays')
                ->get();

            // Replies par identifiant et par topic
            $topics_replies = TopicsReplies::where('topics_replies.forum_id', $forum_topic->forum_id)
                ->where('topics_replies.topic_id', $forum_topic->id)
                ->where('topics_replies.status', 1)
                ->join('users', 'users.id', '=', 'topics_replies.user_id')
                ->select('topics_replies.*', 'users.lastname', 'users.firstname', 'users.avatar', 'users.user_role', 'users.pays')
                ->get();

            // Récuperation de la dernière réponse du topic
            $topic_replie_last = TopicsReplies::where('topics_replies.forum_id', $forum_topic->forum_id)
                ->where('topics_replies.topic_id', $forum_topic->id)
                ->where('topics_replies.status', 1)
                ->join('users', 'users.id', '=', 'topics_replies.user_id')
                ->select('topics_replies.*', 'users.lastname', 'users.firstname', 'users.avatar', 'users.user_role', 'users.pays')
                ->orderBy('topics_replies.created_at', 'DESC')
                ->first();


            TopicsForums::where('url', $url)
                ->update(array('views' => $forum_topic->views + 1));

            if (Auth::check()) {
                return view('forum-topic', compact('forum_topic', 'topics', 'topics_recent', 'forum_categorie', 'forums', 'topics_replies', 'topic_replie_last', 'user'));
            } else {
                return view('forum-topic', compact('forum_topic', 'topics', 'topics_recent', 'forum_categorie', 'forums', 'topics_replies', 'topic_replie_last'));
            }
        } else {
            return redirect()->route('forum');
        }
    }

    /**
     * Create forum
     */
    public function create_forum(Request $request)
    {

        if (Auth::check()) {

            $user = User::where('id', Auth::id())->first();

            if ($user->admin == 1) {

                $validator = Validator::make($request->all(), [
                    'title' => 'bail|required',
                    'content' => 'bail|required',
                    'status' => 'bail|required'
                ]);

                if (!$validator->passes()) {
                    return response()->json(['status' => 0, 'title' => 'Crée un forum', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                } else {

                    $forum = Forums::create([
                        'user_id' => Auth::id(),
                        'title' => $request->title,
                        'url' => Str::slug($request->title),
                        'content' => $request->content,
                        'status' => $request->status
                    ]);

                    $forum->save();

                    if (!empty($request->file_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:pdf'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'Le document doit être au format pdf !', 'title' => 'Ajout de votre maquette !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($request->url . '_') . time() . '.' . $request->file_0->extension();

                            $request->file_0->move(public_path('img/forums'), $fileName);

                            Forums::where('id', $forum->id)
                                ->update(array(
                                    'image' => $fileName,
                                ));
                        }
                    }

                    return response()->json(['status' => 1, 'msg' => 'Le forum a bien été créer.', 'title' => 'Crée un forum', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
                }
            } else {
                return response()->json(['status' => 0, 'title' => 'Créer un forum', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Créer un forum', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Create topic
     */
    public function create_topic(Request $request)
    {
        if (Auth::check()) {

            $user = User::where('id', Auth::id())->first();

            $forum_topic = Forums::where('url', $request->url)
                ->select('id')
                ->first();

            $validator = Validator::make($request->all(), [
                'title' => 'bail|required',
                'signature' => 'bail|required',
                'content' => 'bail|required',
                'status' => 'bail|required'
            ]);

            if (!$validator->passes()) {
                return response()->json(['status' => 0, 'title' => 'Crée un sujet', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                if ($user->admin == 1) {

                    TopicsForums::create([
                        'user_id' => Auth::id(),
                        'forum_id' => $forum_topic->id,
                        'title' => $request->title,
                        'url' => Str::slug($request->title),
                        'signature' => $request->signature,
                        'content' => $request->content,
                        'status' => $request->status,
                        'admin' => $request->admin,
                    ]);
                } else {

                    TopicsForums::create([
                        'user_id' => Auth::id(),
                        'forum_id' => $forum_topic->id,
                        'title' => $request->title,
                        'url' => Str::slug($request->title),
                        'signature' => $request->signature,
                        'content' => $request->content,
                        'status' => $request->status
                    ]);
                }

                return response()->json(['status' => 1, 'msg' => 'Le sujet a bien été créer.', 'title' => 'Crée un sujet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Créer un sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Réponse au topic
     */
    public function reply_topic(Request $request)
    {
        if (Auth::check()) {

            $forum_topic_replies = TopicsForums::where('id', $request->id)
                ->where('status', 1)
                ->first();

            $validator = Validator::make($request->all(), [
                'signature' => 'bail|required',
                'content' => 'bail|required'
            ]);

            if (!$validator->passes()) {
                return response()->json(['status' => 0, 'title' => 'Répondre au sujet', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                TopicsReplies::create([
                    'user_id' => Auth::id(),
                    'forum_id' => $forum_topic_replies->forum_id,
                    'topic_id' => $forum_topic_replies->id,
                    'signature' => $request->signature,
                    'content' => $request->content
                ]);

                return response()->json(['status' => 1, 'msg' => 'Votre réponse au sujet ' . $forum_topic_replies->title . ' a bien été envoyé.', 'title' => 'Répondre au sujet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Répondre au sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Fermer le topic
     */
    public function close_topic(Request $request)
    {
        if (Auth::check()) {

            $user = User::where('id', Auth::id())->first();

            if ($user->admin == 1) {

                $forum_topic = TopicsForums::where('id', $request->idTopic)
                    ->first();

                TopicsForums::where('id', $request->idTopic)->update(array('status' => 0));

                return response()->json(['status' => 1, 'msg' => 'Le sujet ' . $forum_topic->title . ' a bien été fermé.', 'title' => 'Fermer le sujet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'title' => 'Fermer le sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Fermer le sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    public function top_topic(Request $request)
    {
        if (Auth::check()) {

            $user = User::where('id', Auth::id())->first();

            if ($user->admin == 1) {

                $forum_topic = TopicsForums::where('id', $request->idTopic)
                    ->first();

                TopicsForums::where('id', $request->idTopic)->update(array('sticky' => 1));

                return response()->json(['status' => 1, 'msg' => 'Le sujet ' . $forum_topic->title . ' a été remontée.', 'title' => 'Remonter le sujet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'title' => 'Remonter le sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Remonter le sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Fermé le topic utilisateur
     */
    public function close_topic_user(Request $request)
    {
        if (Auth::check()) {

            $forum_topic = TopicsForums::where('id', $request->idTopic)
                ->where('user_id', Auth::id())
                ->first();

            if (!empty($forum_topic)) {

                TopicsForums::where('id', $request->idTopic)->update(array('status' => 0));

                return response()->json(['status' => 1, 'msg' => 'Le sujet ' . $forum_topic->title . ' a bien été fermé.', 'title' => 'Fermer le sujet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'title' => 'Fermer le sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Fermer le sujet', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Rechercher sur le forum
     */
    public function searchForum($terms = null)
    {

        $topics_recent = TopicsForums::orderBy('id', 'DESC')
            ->limit(6)
            ->get();

        // Forums all
        $forums_list = Forums::orderBy('id', 'ASC')
            ->limit(6)
            ->get();

        $forums = Forums::where('forums.title', 'LIKE', "%{$terms}%")
            ->orWhere('forums.content', 'like', "%{$terms}%")
            ->join('users', 'users.id', '=', 'forums.user_id')
            ->select('forums.*', 'users.lastname', 'users.firstname', 'users.avatar', 'users.user_role', 'users.pays')
            ->orderBy('forums.created_at', 'DESC')
            ->get();

        $topics_replies = TopicsReplies::where('topics_replies.content', 'LIKE', "%{$terms}%")
            ->where('topics_replies.status', 1)
            ->join('users', 'users.id', '=', 'topics_replies.user_id')
            ->select('topics_replies.*', 'users.lastname', 'users.firstname', 'users.avatar', 'users.user_role', 'users.pays')
            ->orderBy('topics_replies.created_at', 'DESC')
            ->get();

        return view('forum-search', compact('terms', 'forums', 'topics_replies', 'forums_list', 'topics_recent'));
    }
}

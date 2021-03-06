<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Http\Requests\TopicRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(TopicRequest $request, User $user, Link $link)
    {
        $topics = Topic::withOrder($request->order)->paginate();
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCache();
        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    public function show(Request $request, Topic $topic)
    {
        if (!empty($topic->slug) && $request->slug != $topic->slug) {
            return redirect($topic->links(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();

        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = \Auth::id();
        $topic->excerpt = $request->body;
        $topic->save();

        return redirect()->to($topic->links())->with('success', '成功创建话题');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();

        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic->id)->with('success', '更新成功');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '删除成功');
    }

    public function upload_image(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据 默认是失败的
        $data = [
            'success' => 'false',
            'msg' => '失败',
            'file_path' => '',
        ];
        if ($file = $request->upload_file) {
            $result = $uploader->save($file, 'topics', \Auth::id(), '1024');
            if ($result) {
                $data['success'] = 'true';
                $data['msg'] = '成功';
                $data['file_path'] = $result['path'];
            }
        }

        return $data;
    }
}
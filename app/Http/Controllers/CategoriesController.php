<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Request $request, Category $category, User $user)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = Topic::where('category_id', $category->id)->withOrder($request->order)->paginate();

        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        return view('topics.index', compact('category', 'topics', 'active_users'));
    }
}

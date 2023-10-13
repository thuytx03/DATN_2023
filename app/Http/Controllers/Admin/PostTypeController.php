<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostTypeRequest;
use App\Models\PostType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NestedSet;
use Illuminate\Database\QueryException;


use Illuminate\Support\Facades\DB;

class PostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postTypes = PostType::latest()->paginate(5);
        return view('admin.post-type.index', compact('postTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postTypes = PostType::all();
        return view('admin.post-type.add', compact('postTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostTypeRequest $request)
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $request->image = uploadFile('postTypes', $request->file('image'));
            } else {
                $request->image = null;
            }
            $postType = new PostType();
            $postType->name = $request->name;
            $postType->slug = Str::slug($request->input('name'));
            $postType->description = $request->description;
            $postType->status = $request->status;
            $postType->image = $request->image;
            if ($request->parent_id && $request->parent_id !== 'none') {
                // Here we define the parent for new created category
                $node = PostType::find($request->parent_id);
                $node->appendNode($postType);
            }
            if ($postType->save()) {
                toastr()->success('Thêm mới danh mục thành công!', 'success');
                return redirect()->route('post-type.index');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postTypes = PostType::all();
        $postType = PostType::find($id);
        return view('admin.post-type.edit', compact('postType', 'postTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(PostTypeRequest $request, $id)
    {
        try {
            $postType = PostType::find($id);
            $params = $request->except('_token', 'image');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                Storage::delete('/public/' . $postType->image);
                $request->image = uploadFile('postTypes', $request->file('image'));
                $params['image'] = $request->image;
            } else {
                $request->image = $postType->image;
            }
            if ($params['parent_id'] == 'none') {
                $params['parent_id'] = null;
            }
            $params['slug'] = Str::slug($params['name']);
            // Lấy thông tin cũ của parent_id
            $oldParentId = $postType->parent_id;

            // Sử dụng DB transaction để bảo vệ tính toàn vẹn của nested set
            DB::beginTransaction();

            // Cập nhật thông tin cơ bản của danh mục
            $postType->update($params);

            // Nếu parent_id đã thay đổi, cập nhật vị trí của node trong cây
            if ($params['parent_id'] !== $oldParentId) {
                if ($params['parent_id'] === null) {
                    $postType->makeRoot();
                } else {
                    $newParent = PostType::find($params['parent_id']);
                    $postType->appendToNode($newParent)->save();
                }
            }

            // Commit transaction nếu mọi thứ thành công
            DB::commit();

            toastr()->success('Cập nhật danh mục thành công!', 'success');
        } catch
        (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                // Lỗi duplicate entry
                DB::rollBack(); // Lưu ý: Rollback transaction nếu xảy ra lỗi
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra !', 'error');
        }

        return redirect()->route('post-type.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            $deleted = PostType::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa danh mục thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('post-type.index');
        }
    }
}

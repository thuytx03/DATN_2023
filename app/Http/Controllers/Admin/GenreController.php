<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NestedSet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::latest()->paginate(5);
        return view('admin.genre.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.genre.add',compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $request->image = uploadFile('genres', $request->file('image'));
            } else {
                $request->image = null;
            }
            $genre = new Genre();
            $genre->name = $request->name;
            $genre->slug = Str::slug($request->input('name'));
            $genre->description = $request->description;
            $genre->status = $request->status;
            $genre->image = $request->image;
            if ($request->parent_id && $request->parent_id !== 'none') {
                // Here we define the parent for new created category
                $node = Genre::find($request->parent_id);
                $node->appendNode($genre);
            }
            if ($genre->save()) {
                toastr()->success('Thêm mới thể loại thành công!', 'success');
                return redirect()->route('genre.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genres = Genre::all();
        $genre = Genre::find($id);
        return view('admin.genre.edit', compact('genres', 'genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, $id)
    {
        try {
            $genre = Genre::find($id);
            $params = $request->except('_token', 'image');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                Storage::delete('/public/' . $genre->image);
                $request->image = uploadFile('genres', $request->file('image'));
                $params['image'] = $request->image;
            } else {
                $request->image = $genre->image;
            }
            if ($params['parent_id'] == 'none') {
                $params['parent_id'] = null;
            }
            $params['slug'] = Str::slug($params['name']);
            // Lấy thông tin cũ của parent_id
            $oldParentId = $genre->parent_id;

            // Sử dụng DB transaction để bảo vệ tính toàn vẹn của nested set
            DB::beginTransaction();
            // Cập nhật thông tin cơ bản của danh mục
            $genre->update($params);

            // Nếu parent_id đã thay đổi, cập nhật vị trí của node trong cây
            if ($params['parent_id'] !== $oldParentId) {
                if ($params['parent_id'] === null) {
                    $genre->makeRoot();
                } else {
                    $newParent = Genre::find($params['parent_id']);
                    $genre->appendToNode($newParent)->save();
                }
            }

            // Commit transaction nếu mọi thứ thành công
            DB::commit();
            toastr()->success('Cập nhật thể loại thành công!', 'success');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                // Lỗi duplicate entry
                DB::rollBack(); // Lưu ý: Rollback transaction nếu xảy ra lỗi
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra !', 'error');
        }

        return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            $deleted = Genre::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa thể loại thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('genre.index');
        }
    }
    public function trash()
    {
        $deleteItems = Genre::onlyTrashed()->paginate(5);
        return view('admin.genre.trash', compact('deleteItems'));
    }

    public function restore($id)
    {
        if ($id) {
            $restore = Genre::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục thể loại thành công', 'success');
            return redirect()->route('genre.trash');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $deleted = Genre::onlyTrashed()->find($id);
            $deleted->forceDelete();
            toastr()->success('Xóa vĩnh viễn thể loại thành công', 'success');
            return redirect()->route('genre.trash');
        }
    }
}

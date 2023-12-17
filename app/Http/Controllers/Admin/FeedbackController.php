<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedBack;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = FeedBack::query();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('u.name', 'like', '%' . $search . '%');
        }

        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 'all') {
                $query->join('users as u', 'feed_backs.user_id', '=', 'u.id')
                    ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
                    ->select(
                        'feed_backs.id',
                        'feed_backs.user_id',
                        'u.name as user_name',
                        'feed_backs.movie_id',
                        'movies.name as movie_name',
                        'feed_backs.rating',
                        'feed_backs.message',
                        'feed_backs.created_at',
                        'feed_backs.updated_at'
                    );
            } else {
                $query->join('users as u', 'feed_backs.user_id', '=', 'u.id')
                    ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
                    ->select(
                        'feed_backs.id',
                        'feed_backs.user_id',
                        'u.name as user_name',
                        'feed_backs.movie_id',
                        'movies.name as movie_name',
                        'feed_backs.rating',
                        'feed_backs.message',
                        'feed_backs.created_at',
                        'feed_backs.updated_at'
                    )
                    ->where('feed_backs.rating', $status);
            }
        } else {
            $query->join('users as u', 'feed_backs.user_id', '=', 'u.id')
                ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
                ->select(
                    'feed_backs.id',
                    'feed_backs.user_id',
                    'u.name as user_name',
                    'feed_backs.movie_id',
                    'movies.name as movie_name',
                    'feed_backs.rating',
                    'feed_backs.message',
                    'feed_backs.created_at',
                    'feed_backs.updated_at'
                );
        }

        $feedbacks = $query->orderBy('feed_backs.id', 'DESC')->paginate(5);
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $query = FeedBack::onlyTrashed();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('u.name', 'like', '%' . $search . '%');
        }

        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 'all') {
                $query->join('users as u', 'feed_backs.user_id', '=', 'u.id')
                    ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
                    ->select(
                        'feed_backs.id',
                        'feed_backs.user_id',
                        'u.name as user_name',
                        'feed_backs.movie_id',
                        'movies.name as movie_name',
                        'feed_backs.rating',
                        'feed_backs.message',
                        'feed_backs.created_at',
                        'feed_backs.updated_at'
                    );
            } else {
                $query->join('users as u', 'feed_backs.user_id', '=', 'u.id')
                    ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
                    ->select(
                        'feed_backs.id',
                        'feed_backs.user_id',
                        'u.name as user_name',
                        'feed_backs.movie_id',
                        'movies.name as movie_name',
                        'feed_backs.rating',
                        'feed_backs.message',
                        'feed_backs.created_at',
                        'feed_backs.updated_at'
                    )
                    ->where('feed_backs.rating', $status);
            }
        } else {
            $query->join('users as u', 'feed_backs.user_id', '=', 'u.id')
                ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
                ->select(
                    'feed_backs.id',
                    'feed_backs.user_id',
                    'u.name as user_name',
                    'feed_backs.movie_id',
                    'movies.name as movie_name',
                    'feed_backs.rating',
                    'feed_backs.message',
                    'feed_backs.created_at',
                    'feed_backs.updated_at'
                );
        }

        $feedbacks = $query->orderBy('feed_backs.id', 'DESC')->paginate(5);
        return  view('admin.feedbacks.trash', compact('feedbacks'));
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
            $deleted = FeedBack::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa đánh giá thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('feed-back.index');
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            FeedBack::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các đánh giá đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các đánh giá đã chọn');
        }
    }
    public function delete($id)
    {
        if ($id) {
            $deleted = FeedBack::onlyTrashed()->find($id);
            $deleted->forceDelete();
            toastr()->success('Xóa vĩnh viễn đánh giá thành công', 'success');
            return redirect()->route('feed-back.trash');
        }
    }
    public function restore($id)
    {
        if ($id) {
            $restore = FeedBack::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục đánh giá thành công', 'success');
            return redirect()->route('feed-back.trash');
        }
    }
    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $feedbacks = FeedBack::withTrashed()->whereIn('id', $ids);
            $feedbacks->restore();
            toastr()->success('Thành công', 'Thành công khôi phục đánh giá');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các đánh giá đã chọn');
        }
        return redirect()->route('feed-back.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $feedbacks = FeedBack::withTrashed()->whereIn('id', $ids);
            $feedbacks->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn đánh giá');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các đánh giá đã chọn');
        }
        return redirect()->route('feed-back.trash');
    }
}

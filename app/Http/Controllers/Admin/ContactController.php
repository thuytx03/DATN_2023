<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }
    function sendContact(ContactRequest $request){
        if($request->isMethod('POST')){
            
            Contact::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message')
            ]);
            
            $user = $request->input('name');
            $email = $request->input('email');
            $subject = $request->input('subject');
            $content = $request->input('message');
            Mail::send('admin.contact.mail', compact('email','user','subject','content'), function ($message) use ($user,$email,$subject,$content) {

                $message->from($email, $user);
                $message->to('nobrain1412@gmail.com', 'nobrain');
                $message->subject($subject);
            });
            toastr()->success('Gửi phản hồi thành công, chúng tôi sẽ liên lạc với bạn sớm nhất có thể!');
            return view('client.contacts.contact');

        }
        return view('client.contacts.contact');
    }

    public function index()
    {
        $contact = Contact::latest()->paginate(5);
        return view('admin.contact.index', compact('contact'));
    }

    public function replied(ContactRequest $request,$id)
    {
        $contact = Contact::find($id);
        if($request->isMethod('POST')){
            $user = $request->input('name');
            $email = $request->input('email');
            $subject = $request->input('subject');
            $content = $request->input('message');
            //dd($message);
            Mail::send('admin.auth.mail', compact('email','user','subject','content'), function ($message) use ($user,$email,$subject,$content) {

                $message->from($email, $user);
                $message->to('nobrain1412@gmail.com', 'nobrain');
                $message->subject($subject);
                $message->text($content);
            });
        }
        return view('admin.contact.replied', compact('contact'));
    }

    
    public function reply($id){
        $contact = Contact::find($id);
        return view('admin.contact.replied', compact('contact'));
    }
    public function destroy($id)
    {
        if ($id) {
            $deleted = Contact::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa thư thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('contact.index');
        }
    }

    public function search(Request $request){
        $status = $request->input('status');
        $search = $request->input('search');
        $contacts = Contact::query();
        if ($status) {
            $contacts->where('status', $status);
        }
    
        if ($search) {
            $contacts->where('name', 'like', '%' . $search . '%');
        }
        $contact = $contacts->paginate(10);

        if($contact){
            return view('admin.contact.index', compact('contact'));
        }

    }
    public function trash()
    {
        $contact = Contact::onlyTrashed()->get();
        return view('admin.contact.trash', compact('contact'));
    }
    public function updateStatus(Request $request, $id)
    {
        $item = Contact::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }
    public function permanentlyDelete($id)
    {
        $voucher = Contact::withTrashed()->findOrFail($id);
        $voucher->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn thư');
        return redirect()->route('contact.trash');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Contact::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá thư đã chọn');
        } else {
            toastr()->warning('Không tìm thấy thư đã chọn');
        }
    }

    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $contact = Contact::withTrashed()->whereIn('id', $ids);
            $contact->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn thư');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy thư đã chọn');
        }
        return redirect()->route('contact.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $contact = Contact::withTrashed()->whereIn('id', $ids);
            $contact->restore();
            toastr()->success('Thành công', 'Thành công khôi phục thư');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các thư đã chọn');
        }
        return redirect()->route('contact.trash');
    }
    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        Contact::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();
        return redirect()->route('contact.index')->withSuccess('Đã xoá vĩnh viễn mã giảm giá trong thùng rác');
    }
}

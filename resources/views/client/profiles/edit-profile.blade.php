@extends('client.profiles.layout.temp')
@section('profile')
<style>
    form {
        /* margin-top: 20px; */
    }

    label {
        margin-top: 20px;
    }
</style>
<section>
    <h4 class="mt-2">Cập nhật thông tin cá nhân</h4>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif
    <form action="{{route('profile.edit')}}" method="post" class="" enctype="multipart/form-data">
        @csrf
        <div class="d-flex">
            <div class="col-5">
                <label for="">Họ tên</label>
                <input type="text" name="name" value="{{$user->name}}">
                <label for="">Email</label> 
                <input type="text" name="email" value="{{$user->email}}" id="">
                <label for="">Số điện thoại</label>
                <input type="text" name="phone" value="{{$user->phone}}">
                <label for="">Địa chỉ</label>
                <input type="text" name="address" value="{{$user->address}}">
                
            </div>
            <div class="col-5" style="margin: 20px 50px;">
                <div class="image" style="margin-top: 30px;">
                    <img style="border-radius: 50%;" width="150px" height="150px" src="{{ ($user->avatar == null) ? asset('admin/img/undraw_profile_1.svg') : Storage::url($user->avatar) }}" id="image_preview">
                    <input name="avatar" type="file" id="image_url" style="display: none">
                </div>
                <label for="" style="margin-top: 31px;">Giới tính</label>
                <select name="gender" id="" style="background-color: #032055;">
                    @if($user->gender == 1)
                    <option selected value="1">Nam</option>
                    <option value="2">Nữ</option>
                    @else
                    <option value="1">Nam</option>
                    <option selected value="2">Nữ</option>
                    @endif
                </select>
                <button type="submit" class="btn btn-success" style="margin-top: 50px; background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);">Cập nhật</button>
                
            </div>
        </div>

    </form>
</section>
<script src="{{ asset('upload_file/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('upload_file/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('upload_file/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    const imagePreview = document.getElementById('image_preview');
    const imageUrlInput = document.getElementById('image_url');

    $(function() {
        function readURL(input, selector) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $(selector).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image_url").change(function() {
            readURL(this, '#image_preview');
        });

    });
    imagePreview.addEventListener('click', function() {
        imageUrlInput.click();
    });

    imageUrlInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    // Add an event listener to select/deselect all checkboxes
    document.getElementById('select-all-checkboxes').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="parent_id[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection
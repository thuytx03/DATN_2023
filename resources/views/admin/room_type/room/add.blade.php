@extends('layouts.admin')
@section('content')

@section('title')
Thêm phòng
@endsection
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{route('room.list')}}" class="btn btn-success m-3">Danh sách phòng</a>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{route('room.add')}}" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-2 text-gray-800">Thêm mới phòng</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Loại phòng</label>
                            <br>
                            <select class="form-select border border-1 rounded w-100 p-2" name="room_type_id">
                                <option value="0">Vui lòng chọn</option>
                                @foreach($typeRoom as $typeRoom)
                                <option value="{{$typeRoom->id}}">{{$typeRoom->name}}</option>
                                <!-- Add more options as needed -->
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên rạp</label>
                            <br>
                            <select class="form-select border border-1 rounded w-100 p-2" name="cinema_id">
                                @foreach($cinema as $cinema)
                                <option value="{{$cinema->id}}">{{$cinema->name}}</option>
                                @endforeach
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Hình ảnh</label>
                            <br>
                            <img id="mat_truoc_preview" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAhFBMVEX////u7u4AAADt7e3v7+/+/v709PT5+fny8vIEBAT6+vrp6emmpqbk5ORPT08sLCzT09NKSkpqamq+vr48PDxycnKysrIpKSkzMzPGxsbMzMweHh62trbe3t6Xl5eMjIwXFxegoKBZWVkaGhqIiIhAQEB4eHhjY2OTk5MPDw+AgIBdXV3eHf3TAAALN0lEQVR4nO2diWKqOhBAA1khUqlb3ehiq5W+//+/l0yCAlJtLQh4M10s7RhznJDMEijySkIoyglVH6zfKqjDfXOEjtARtt83R+gIHWH7fXOEjtARtt83R/gbQnz4JgiiWhA6fGO41yonNhSoLAL3WgVxpuT4rfjAtbB+q5y8BRR7uTcBYyl5z1VyI9gMaUwKA5l4vN8qF2xICMZhz1VOn0JKT6kYGb1S6XLfHKEjdITt980ROkJH2H7fHKEj/HcJ86Iirip/vlcquCTeCTPrt8q/kmvrZt8coSN0hO33zRE6wkYJiwvxtSqdIySSCUaEEIRVOIf6D0e5oEIEJ6J7hB6T67GRxbIsi3FJLqosROcIiZj5dQrvHiFThEFd0kVCzNb23Q9yD8HhsCA/UKmTsJ7KsmcIqzr7a9GN0M5VuaUwNlytVu/vq7K8FuVblXclKRDyzlW5QzQGwnEioyiJkoKUDs+rfAAh6mCVewGEUqkw4pGcqFnopJVvVHQWYm8IO1jlXsAZpLyVkOVfWBBPMPPUgxxUiAAjiEwFcYqeM8LOVbmNDaOqFFhFK0RnjjheDF5e3sYRIxwA9ddzlQ07UeU+Q1jdihCDBzN5bt8iDRgWCTuXL/01oRzpcR3oT/8hRtzO/XdD6MlPcIJShai+VhjdGaHHXhRgald4ZcZdNgvdC6FIYIT66WT7an4aIHpP56HkezDediaj5YMerf4oRPdDSKn0NqCeUCx59KBhn5I7Igypl8y19hdXi4YOS/QwXd4RofJG4idNNVPujPJ5Ej3Z+GN0PzMNpSKe65G5Z0IKTNawMC7vihBjOA9fJcNYiJGGWkX3RIgw+wKQ/5Yqap3CgviA7strY7EJ5lebzdxE9YPb+DR/qCznCPNCvKpWJOYj48uAU6Met9iEPEfCP/TlIHVWlm0WIyFHFRqqSFAPvcpWyMZPA5uf008UQvcRK28Oshidq3JnubaEHFUU3Hg6HVMkKltJ/rMuqfJOJ2seManCPZIRdjabmCekkLsJxoiXc0hahSP2PDTxYfqVcCKIOpN6RsjDjQ4fNmEZEFT0WScHH5+f00GiWoGgv2+EaGnmy2WlDUOdVLGKYcjUvNgrG5qsy8hkiEdMCDUVGT0CnyifJcq10iNCPc/EK5gp/fdYG8c2gIW2Fu0/oZpH0Resd+prGnpCmuerSIJFgoW9J9QmJFmCIvAjkSX+JIs/nx4HiFa30idCrp0TY8PAf+H2NPSEmCqtVYLCylb6Q0hpGA21/VYQBw5joWcYQjy+hFhw1/tRyjl6g0H6bNzMPZVSe6hY7OBYGbHnhJSSiTbeUxSBESdSu/4KMHmCk9N/7jshR1D09j8Q+jC5QgYrBvuwWe5J1HNCSjcwSGOEYujxg6d9FslsMJH6s2pCrwHCWqvcmlDn51W0qGu5Ox097WA6nSkjCv6chYN+ikKaa4rZahvhLx2vcicCC53ancIWhLFe98aQu/8kkkTyMVtBfH9c0YqODz86XuWOOBfql/G7pthwFoacP+g+p0tlzhkM3U/wxzeChycvpObgfQ+q3FjyTzO9cEmkpIMUXDf1F4h535ORDqrSQVYrLr5QZYW0M1VuTagTaREMxG3kMSyElFswmtDRlHocaVX1509mHJ18K6eZqA5WuSmVfAdr3kCFvlhnwAZw+IE+4XFJqTHxgpVb6UeVm4c2oZ1iqNbryRWWwMd1qnMyG/UEs1hO7cRwbKUf+VLK0Itxt5mOKIiK3q0TPoRBulbjmE/gLYhZLwkRjcBhGyZqjVfrvAp5w2gO4xMsyfQZpNZFZdAP0UtCigbw006oUEKF9EqfK9fNblz033TcxCJYTeYJKZ5BtyMkMMupo7Cw0Ud/XrYh24LBYuvsqJHKaZKapd5/EDpRHLI9GHSvplOdrfYyG57uGGqIUDJd1vOKhJA9ukSoXLYxwEyziVKphyj8sh73M8zgVJj64as5VbWKfQ1+MxtiTy3WavBoofAdXbZhoNdDPtKnWLrgZuc2U5/qr8uVMaJ1M6RC1voDSlimYmV/E0KduiRclNwe7b1fIlwnA7DOdpGTOI6XxiPdJDHIYjkD9f8Wi2WmYuXrNjMNwUw+K3nLyYxdJNRhUerbWktJgpPfV6r5/m1siMXi9JVfk3OE48reXiGwrjRNyCI2Lb6qmSYuzzQ1Md5gPeQPRzS7e9uEB9+0Susk9G+xWpDH0q70ILhEmJo1PQ2yuue3cl4l1R9NV7nVQvh4MnQs4XeVZZbNh8vFOHcFTGmm/JnKMr5BlRt2Yu2QDaIRAI/YmcqyJ8yebXGaXOCkKBdVBLnBtdxAOKVgfg8zS9ilS+/+mk20hCYFhvn9EppRc8+E1gO441Fqfu/dsQ0doSN0hH9QIZevCO8bIeyZynkszGQdbGr7LggZFvlL+oBQ57XuhpBEh3ITXNN3zLHeCyFm0eAlJ/vn530M17zdC6GQm5NIOZ2h8JINK8vGQOgfvDZiCUWrtyNnpsCaC831RnF0ppWzVe48ocz8Uo5bvB05g9s2BMGBEB6H51r5tsrNODch79SohKE9pK3ejpzOSglJ/eMT4+EVVW6chUslk+ZUrN5Nb0cOmyHS7aMV2Fb25FXWyo/tVJeND1OLVaF24kHt3o4cCIdqzTD1AqhwPOGrqtx5wnM2vLb4fKXKDJAO/R7kCX9Z5T5HWEeS70qVi4S/qD05QkfoCB2hI3SEjtAROkJH2CbhoWLMviFEOH+XLkFK+RSQxlSqCf9U5Z7SI7DewRTHSVSWpFykb07lRb/NByQbH+bfmyur3MdB+zp/Gg7nOVEHw7IolWFDKisI6rG9WPNAWF++tHqP1i0FEjONEQa+3ZtWftXynTlPd6vVo2J70KQNq9/TH7zttakEjRJ+t5PwlhI0fB76D7PZely64e94PCtJcyq7xkfplLPTbBYVRWlOhdsFsMGZZsQxQ/n7WGrF8g0TmlNhs4YJA3/EpMgaNK2qI1bqW3MqYtD0eqgICSkOnKryemMqDC7kaJiw1fqhI3SEPyIkXkV5vdRIYyoHQvw7wsrKckWVG+ZSzCjNhZn6XlcsF8bBTs3GVJiZS4lF1ITqMER1Vrk9woqTODqNybzmVLKgHoYp5oYwb+u/VbkDfRhyHvLjQmxqy0VpToWaFV/9DJ2kb0BoD+upco8wjpJ8NA53Uy9nChpTEW/glx78uTcAzu5eVEOV2/dX2+1kMp9PDgLx96Qozalsh4DEs46bQauvs/PqqXJ3IXrygwar3IHd6VG6/qwqfm1IJbhI+Ld8aRBU9uOG0jRhdvftVqXRnLe+iep6UCGl4Lw5lfX0Fll9JJhgOam4hKk5FVe3cISO8P4Idbhk7sKp4pgOEUK4pFWM5/0XGwaZDSntEiHPjFjjKFVNbjpDOKx1lD4O1lpms/WkM4Qr0yfVq5FJ8l9f5S6WYtKMsBCJ45v+0+2ZX6y6mULNuVbKUefxXuN2WBZcQnVaEq/Nf7rN3ioiuCur3CGtJJwK0nI2sYrw4hUlVa3CzYxOZdByvnRZEb19ZreV/iWhcnz3c5s8yGT7Utc/QL1SRdLBY6FH88l8l2RJx99mhNVPUsrCJpBEAbZ77ZrkUXFDipSc8muvXTPCCv/Dr8nu/0BFJ5sKgi614v6nc8e77wgdYfe77wgdYfe77wi9s1Xu21+o3YhKnXcs76ZKnXcs76bKyVvQ6oXajaig76rc9ttNL9RuQuWCDW98oXYjKqdPaTFV2IhKl/vmCB2hI2y/b47QETrC9vvmCB3hv0vYYgm7EZWb1afbUvlXcm3d7JsjdISOsP2+OUJH6Ajb75sjdISOsP2+1aPyP7xd9r0ZPL3LAAAAAElFTkSuQmCC" alt="your image" style="max-width: 200px; height:100px; margin-bottom: 10px;" class="img-fluid" />
                            <input type="file" name="image" accept="image/*" class="form-control-file @error('image') is-invalid @enderror" id="cmt_truoc">
                            <label for="cmt_truoc"></label><br />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <button type="reset" class="btn btn-danger">Nhập lại</button>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
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

        $("#cmt_truoc").change(function() {
            readURL(this, '#mat_truoc_preview');
        });

        $('#cmt_truoc').on('change', function() {
            var files = $(this)[0].files;

            // Clear previous previews
            $('#image_preview_container').html('');

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_preview_container').append('<img src="' + e.target.result + '" class="img-fluid" style="max-width: 200px; height:100px; margin-bottom: 10px;">');
                }

                reader.readAsDataURL(files[i]);
            }
        });
    });
</script>
@endpush
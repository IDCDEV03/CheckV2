@section('title', 'Admin')
@section('description', 'ทดสอบ')
@extends('layout.LayoutAdmin')
@section('content')

    <div class="container-fluid">
        <div class="social-dash-wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">แก้ไขประกาศ</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    {{-- โพสต์ประกาศ --}}
                    <div class="card mb-25">
                        <div class="card-body">
                          

                            <form action="#" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="title" class="form-label">หัวข้อประกาศ <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $announce->title) }}">

                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label">เนื้อหา <span class="text-danger">*</span>

                                    </label>
                                    <textarea class="form-control" id="editor" name="detail" rows="5">
                                    {{ old('detail', $announce->description) }}
                                    </textarea>

                                </div>

                                <div class="mb-3">
                                    <label for="attachment" class="form-label">ไฟล์แนบ (ถ้ามี)</label>
                                    <input type="file" class="form-control custom-file-input" id="attachment"
                                        name="file_upload">
                                    <span class="fs-12">รองรับเฉพาะ PDF, DOCX, JPG, PNG ขนาดไม่เกิน 5MB</span>

                                </div>

                                <button type="submit" class="btn btn-success">
                                    บันทึก
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.tiny.cloud/1/dwhh7ntpqcizas3qtuxlr6djbra54faczek8pufkr4g9sjp4/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#editor',
            menubar: false,
            plugins: 'link lists',
            toolbar: 'fontsize | undo redo | bold italic underline | bullist numlist | link',
            font_size_formats: '12pt 14pt 16pt 18pt 24pt 36pt 48pt',
            height: 300,
            branding: false
        });
    </script>


@endsection

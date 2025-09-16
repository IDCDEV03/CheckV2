@section('title', 'ระบบ E-Checker')
@section('description', 'ID Drives')
@extends('layout.guest_app')
@section('content')
    <div class="container-fluid">
        <div class="social-dash-wrap">

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class=" alert alert-primary " role="alert">
                        <div class="alert-content">
                            <span class="fs-20 fw-bold"> {{ $forms->form_name }} </span>
                        </div>
                    </div>

                    <div class="card mb-25">
                        <div class="card-body">
                          

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <p class="fs-20 fw-bold">หมวดหมู่ที่ / Category No. {{ $category->cates_no }} : {{ $category->chk_cats_name }}</p>
          <form method="POST" action="{{ route('guest.chk_insert_step2', [$record->record_id, $category->category_id]) }}" enctype="multipart/form-data">
        @csrf

                                @foreach ($items as $item)
                              
                                    <div class="mb-3 border-success rounded p-3">
                                        <label class="fw-bold fs-18">{{ $item->item_no }}. {{ $item->item_name }}</label>
                                        @if (empty($item->item_image))
                                        @else
                                            <p></p><img src="{{asset($item->item_image)}}" class="img-thumbnail mb-2" width="400px" alt=""><br>
                                        @endif

                                        @if (empty($item->item_description))
                                        @else
                                            <br>
                                            <span class="mt-2">{{$item->item_description}}</span>
                                        @endif
                                        
                                        <select name="item_result[{{ $item->id }}]" class="form-select mt-2" required>
                                            @if ($item->item_type == '1')
                                                <option value="1" selected>✅ ผ่าน/Pass</option>
                                                <option value="2">⚠️ ไม่ผ่าน แต่ยังสามารถใช้งานได้/Abnormal but functional</option>
                                                <option value="0">❌ ห้ามใช้งาน/Not to be used</option>
                                                <option value="3">⛔ ไม่เกี่ยวข้อง/Not applicable</option>
                                            @elseif ($item->item_type == '2')
                                                <option value="1" selected>✅ ปกติ / Normal</option>
                                                <option value="2">⚠️ ไม่ปกติ แต่ยังสามารถใช้งานได้ /Abnormal but functional</option>
                                                <option value="0">❌ ไม่สามารถใช้งานได้/Not functional</option>
                                                <option value="3">⛔ ไม่เกี่ยวข้อง/Not applicable</option>
                                            @endif
                                        </select>
                                        <textarea name="user_comment[{{ $item->id }}]" class="form-control mt-2" placeholder="ความคิดเห็นเพิ่มเติม (ถ้ามี)/ Comment (if any)"></textarea>

                                         <label class="mt-2">อัปโหลดภาพ (ไม่เกิน 3 ภาพ)/Upload images (maximum 5 images)</label>
        <input type="file" name="item_images[{{ $item->id }}][]" class="form-control image-input-multi" multiple accept="image/*">
        <div class="preview-multi d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>

                                    
                                @endforeach

                                <div class="border-top my-3"></div>

                                <button type="submit" class="btn btn-block btn-success fs-18">บันทึกและไปต่อ / Save and continue <i
                                        class="fas fa-arrow-right"></i></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.image-input-multi').forEach(input => {
    input.addEventListener('change', function () {
        const previewContainer = this.nextElementSibling;
        previewContainer.innerHTML = '';

        const files = this.files;
        if (files.length > 5) {
            alert('ไม่สามารถอัปโหลดได้เกิน 5 รูป');
            this.value = '';
            return;
        }

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '120px';
                img.classList.add('rounded', 'border');
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">แก้ไขข้อมูลคำขอพัฒนาซอฟต์แวร์ (Edit Software)</h2>

        {{-- Main Edit Form (AJAX submission) --}}
        <form id="updateSoftwareForm" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Row 1: ชื่อ, นามสกุล, แผนก --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="f_name" class="form-label">ชื่อ *</label>
                    <input type="text" name="f_name" id="f_name" class="form-control"
                        value="{{ old('f_name', $software->f_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="l_name" class="form-label">นามสกุล *</label>
                    <input type="text" name="l_name" id="l_name" class="form-control"
                        value="{{ old('l_name', $software->l_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="department_id" class="form-label">แผนก *</label>
                    <select name="department_id" id="department_id" class="form-control" required>
                        <option value="" disabled>เลือกแผนก</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}"
                                {{ old('department_id', $software->department_id) == $department->department_id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 2: เบอร์โทร & วันที่ขอ --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tel" class="form-label">เบอร์โทรติดต่อกลับ *</label>
                    <input type="text" name="tel" id="tel" class="form-control"
                        value="{{ old('tel', $software->tel) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">วันที่ขอ *</label>
                    <input type="date" name="date" id="date" class="form-control"
                        value="{{ old('date', $software->date) }}" required>
                </div>
            </div>

            {{-- Row 3: ชื่อระบบ --}}
            <div class="mb-3">
                <label for="software_name" class="form-label">ชื่อระบบ *</label>
                <input type="text" name="software_name" id="software_name" class="form-control" placeholder="ชื่อระบบ"
                    value="{{ old('software_name', $software->software_name) }}" required>
            </div>

            {{-- Row 4: ปัญหาที่เกิดขึ้นจากระบบเดิม --}}
            <div class="mb-3">
                <label for="problem" class="form-label">ปัญหาที่เกิดขึ้นจากระบบเดิม *</label>
                <textarea name="problem" id="problem" rows="3" class="form-control" required>{{ old('problem', $software->problem) }}</textarea>
            </div>

            {{-- Row 5: วัตถุประสงค์การพัฒนาระบบใหม่ --}}
            <div class="mb-3">
                <label for="purpose" class="form-label">วัตถุประสงค์การพัฒนาระบบใหม่ *</label>
                <textarea name="purpose" id="purpose" rows="3" class="form-control" required>{{ old('purpose', $software->purpose) }}</textarea>
            </div>

            {{-- Row 6: กลุ่มเป้าหมายการใช้งาน --}}
            <div class="mb-3">
                <label for="target" class="form-label">กลุ่มเป้าหมายการใช้งาน *</label>
                <textarea name="target" id="target" rows="2" class="form-control" required>{{ old('target', $software->target) }}</textarea>
            </div>

            {{-- File Upload (new files) --}}
            <div class="mb-3">
                <label for="files" class="form-label">ไฟล์แนบ (ถ้ามี)</label>
                <input type="file" name="files[]" id="files" class="form-control" multiple>
                <small class="text-muted">You can upload multiple files.</small>
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('softwares.show', $software->software_id) }}" class="btn btn-danger me-2">
                    ยกเลิก
                </a>
                <button type="submit" class="btn btn-success">
                    บันทึกการแก้ไข
                </button>
            </div>
        </form>

        <hr>

        {{-- Existing Uploaded Files --}}
        <h5>ไฟล์แนบที่มีอยู่</h5>
        <ul id="fileList" class="list-group mt-2">
            @foreach ($software->uploadedFiles as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                        {{ $file->original_name }}
                    </a>
                    <button class="btn btn-danger btn-sm deleteFileBtn" data-file-id="{{ $file->files_id }}">
                        ลบ
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Non-AJAX Validation Errors (Fallback) --}}
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        // 1) Intercept the main form submission (AJAX)
        document.getElementById('updateSoftwareForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("{{ route('softwares.update', $software->software_id) }}", {
                    method: 'POST', // We'll rely on _method=PATCH
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw response;
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = "{{ route('softwares.show', $software->software_id) }}";
                    } else {
                        alert('An error occurred updating software.');
                    }
                })
                .catch(async (errResp) => {
                    if (errResp.status === 422) {
                        const errorData = await errResp.json();
                        console.error('Validation errors:', errorData.errors);
                        alert('Validation failed.');
                    } else {
                        console.error('Error response:', errResp);
                        alert('Something went wrong.');
                    }
                });
        });

        // 2) Handle file deletion via AJAX
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('deleteFileBtn')) {
                const fileId = e.target.dataset.fileId;
                if (!confirm('ต้องการลบไฟล์นี้ใช่หรือไม่?')) return;

                fetch(`/softwares/ajax-delete-file/${fileId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            e.target.closest('li').remove();
                        } else {
                            alert('Error deleting file.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Could not delete file.');
                    });
            }
        });
    </script>
@endsection

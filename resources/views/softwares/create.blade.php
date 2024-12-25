@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">เพิ่มข้อมูลคำขอพัฒนาซอฟต์แวร์</h2>

    <form action="{{ route('softwares.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <!-- First Name -->
            <div class="col-md-4">
                <label for="f_name" class="form-label">ชื่อ *</label>
                <input 
                    type="text" 
                    name="f_name" 
                    id="f_name" 
                    class="form-control"
                    value="{{ old('f_name', $user->f_name) }}" 
                    placeholder="ชื่อ" 
                    required 
                    readonly
                >
            </div>

            <!-- Last Name -->
            <div class="col-md-4">
                <label for="l_name" class="form-label">นามสกุล *</label>
                <input 
                    type="text" 
                    name="l_name" 
                    id="l_name" 
                    class="form-control"
                    value="{{ old('l_name', $user->l_name) }}" 
                    placeholder="นามสกุล" 
                    required 
                    readonly
                >
            </div>

            <!-- Department -->
            <div class="col-md-4">
                <label for="department_id" class="form-label">แผนก *</label>
                <select name="department_id" id="department_id" class="form-control" required>
                    <option value="" disabled selected>เลือกแผนก</option>
                    @foreach($departments as $department)
                        <option 
                            value="{{ $department->department_id }}"
                            {{ $user->department == $department->department_id ? 'selected' : '' }}
                        >
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Contact and Date -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tel" class="form-label">เบอร์โทรติดต่อกลับ *</label>
                <input 
                    type="text" 
                    name="tel" 
                    id="tel" 
                    class="form-control"
                    value="{{ old('tel', $user->tel ?? '') }}" 
                    placeholder="เบอร์โทรติดต่อกลับ" 
                    required
                >
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">วันที่ขอ *</label>
                <input 
                    type="date" 
                    name="date" 
                    id="date" 
                    class="form-control"
                    value="{{ old('date') }}" 
                    required
                >
            </div>
        </div>

        <!-- Software Name -->
        <div class="mb-3">
            <label for="software_name" class="form-label">ชื่อระบบ *</label>
            <input 
                type="text" 
                name="software_name" 
                id="software_name" 
                class="form-control"
                placeholder="ชื่อระบบ" 
                value="{{ old('software_name') }}"
                required
            >
        </div>

        <!-- Problem -->
        <div class="mb-3">
            <label for="problem" class="form-label">ปัญหาที่เกิดขึ้นจากระบบเดิม *</label>
            <textarea 
                name="problem" 
                id="problem" 
                rows="3" 
                class="form-control" 
                placeholder="ปัญหาที่เกิดขึ้นจากระบบเดิม" 
                required
            >{{ old('problem') }}</textarea>
        </div>

        <!-- Purpose -->
        <div class="mb-3">
            <label for="purpose" class="form-label">วัตถุประสงค์การพัฒนาระบบใหม่ *</label>
            <textarea 
                name="purpose" 
                id="purpose" 
                rows="3" 
                class="form-control" 
                placeholder="วัตถุประสงค์การพัฒนาระบบใหม่" 
                required
            >{{ old('purpose') }}</textarea>
        </div>

        <!-- Target -->
        <div class="mb-3">
            <label for="target" class="form-label">กลุ่มเป้าหมายการใช้งาน *</label>
            <textarea 
                name="target" 
                id="target" 
                rows="2" 
                class="form-control"
                placeholder="กลุ่มเป้าหมายการใช้งาน" 
                required
            >{{ old('target') }}</textarea>
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="files" class="form-label">ไฟล์แนบ (ถ้ามี)</label>
            <input 
                type="file" 
                name="files[]" 
                id="files" 
                class="form-control" 
                multiple
            >
            <small class="text-muted">You can select multiple files at once.</small>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('home') }}" class="btn btn-danger me-2">ยกเลิก</a>
            <button type="submit" class="btn btn-success">ตกลง</button>
        </div>
    </form>
</div>

<!-- Error Handling (Modal + Inline Alert) -->
@if($errors->any())
    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">ข้อผิดพลาด</h5>
                    <button 
                        type="button" 
                        class="btn-close btn-close-white" 
                        data-bs-dismiss="modal" 
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal"
                    >
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline Alert (optional if you want both) -->
    <div class="alert alert-danger my-2">
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
    document.addEventListener('DOMContentLoaded', () => {
        @if($errors->any())
            const myModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                keyboard: false
            });
            myModal.show();
        @endif
    });
</script>
@endsection

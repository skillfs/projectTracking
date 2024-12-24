@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">เพิ่มข้อมูลคำขอพัฒนาซอฟต์แวร์</h2>

        <form action="{{ route('softwares.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <!-- First Name -->
                <div class="col-md-4">
                    <label for="f_name" class="form-label software_label">ชื่อ <span class="text-danger">*</span></label>
                    <input type="text" name="f_name" id="f_name" class="form-control"
                        value="{{ old('f_name', $user->f_name) }}" placeholder="ชื่อ" required readonly>
                </div>

                <!-- Last Name -->
                <div class="col-md-4">
                    <label for="l_name" class="form-label software_label">นามสกุล <span class="text-danger">*</span></label>
                    <input type="text" name="l_name" id="l_name" class="form-control"
                        value="{{ old('l_name', $user->l_name) }}" placeholder="นามสกุล" required readonly >
                </div>

                <!-- Department -->
                <div class="col-md-4">
                    <label for="department_id" class="form-label software_label">แผนก <span class="text-danger">*</span></label>
                    <select name="department_id" id="department_id" class="form-control" required style="pointer-events: none">
                        <option disabled selected>เลือกแผนก</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}"
                                {{ $user->department == $department->department_id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Contact and Date -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tel" class="form-label software_label">เบอร์โทรติดต่อกลับ <span class="text-danger">*</span></label>
                    <input type="text" name="tel" id="tel" class="form-control"
                        value="{{ old('tel', $user->tel ?? '') }}" placeholder="เบอร์โทรติดต่อกลับ" required>
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label software_label">วันที่ขอ <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control"
                        value="{{ old('date', now()->format('Y-m-d')) }}" required readonly>
                </div>
            </div>

            <!-- Software Name -->
            <div class="mb-3">
                <label for="software_name" class="form-label software_label">ชื่อระบบ <span class="text-danger">*</span></label>
                <input type="text" name="software_name" id="software_name" class="form-control" placeholder="ชื่อระบบ"
                    required>
            </div>

            <!-- Problem -->
            <div class="mb-3">
                <label for="problem" class="form-label software_label">ปัญหาที่เกิดขึ้นจากระบบเดิม <span class="text-danger">*</span></label>
                <textarea name="problem" id="problem" rows="3" class="form-control" placeholder="ปัญหาที่เกิดขึ้นจากระบบเดิม"
                    required></textarea>
            </div>

            <!-- Purpose -->
            <div class="mb-3">
                <label for="purpose" class="form-label software_label">วัตถุประสงค์การพัฒนาระบบใหม่ <span class="text-danger">*</span></label>
                <textarea name="purpose" id="purpose" rows="3" class="form-control" placeholder="วัตถุประสงค์การพัฒนาระบบใหม่"
                    required></textarea>
            </div>

            <!-- Target -->
            <div class="mb-3">
                <label for="target" class="form-label software_label">กลุ่มเป้าหมายการใช้งาน <span class="text-danger">*</span></label>
                <textarea name="target" id="target" rows="2" class="form-control" placeholder="กลุ่มเป้าหมายการใช้งาน"
                    required></textarea>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('home') }}" class="btn btn-danger me-2">ยกเลิก</a>
                <button type="submit" class="btn btn-success">ตกลง</button>
            </div>
        </form>
    </div>
    <!-- Error Modal -->
    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">ข้อผิดพลาด</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                    keyboard: false
                });
                myModal.show();
            });
        </script>
    @endif
@endsection
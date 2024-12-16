@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">เพิ่มข้อมูลคำขอพัฒนาซอฟต์แวร์</h3>

    <!-- Request Form -->
    <form method="POST" action="{{ route('softwares.store') }}">
        @csrf
        <!-- Name, Department, Phone -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">ชื่อผู้ขอ <span class="text-danger">*</span></label>
                <input type="text" name="f_name" class="form-control" placeholder="ชื่อ นามสกุล" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">แผนก <span class="text-danger">*</span></label>
                <input type="text" name="department_id" class="form-control" placeholder="แผนก" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">เบอร์ติดต่อกลับ <span class="text-danger">*</span></label>
                <input type="tel" name="tel" class="form-control" placeholder="เบอร์โทรติดต่อกลับ" required>
            </div>
        </div>

        <!-- System Name and Date -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">ชื่อระบบ <span class="text-danger">*</span></label>
                <input type="text" name="software_name" class="form-control" placeholder="ชื่อระบบ" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">วันที่ขอ <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="date" name="date" class="form-control" required>
                    <span class="input-group-text">
                        <i class="bi bi-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <!-- Problem and Objectives -->
        <div class="mb-3">
            <label class="form-label">ปัญหาที่เกิดขึ้นจากระบบเดิม <span class="text-danger">*</span></label>
            <textarea name="problem" class="form-control" rows="3" placeholder="ปัญหาที่เกิดขึ้นจากระบบเดิม" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">วัตถุประสงค์การพัฒนาระบบใหม่ <span class="text-danger">*</span></label>
            <textarea name="purpose" class="form-control" rows="3" placeholder="วัตถุประสงค์การพัฒนาระบบใหม่" required></textarea>
        </div>

        <!-- Target Group -->
        <div class="mb-3">
            <label class="form-label">กลุ่มเป้าหมายการใช้งาน <span class="text-danger">*</span></label>
            <textarea name="target" class="form-control" rows="3" placeholder="กลุ่มเป้าหมายการใช้งาน" required></textarea>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('softwares.list') }}" class="btn btn-danger me-2">ยกเลิก</a>
            <button type="submit" class="btn btn-success">ตกลง</button>
        </div>
    </form>
</div>
@endsection
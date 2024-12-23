@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">แก้ไขข้อมูลคำขอพัฒนาซอฟต์แวร์</h2>

        <form action="{{ route('softwares.update', $software->software_id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="row mb-3">
                <!-- First Name -->
                <div class="col-md-4">
                    <label for="f_name" class="form-label">ชื่อ *</label>
                    <input type="text" name="f_name" id="f_name" class="form-control"
                        value="{{ old('f_name', $software->f_name) }}" placeholder="ชื่อ" required readonly>
                </div>

                <!-- Last Name -->
                <div class="col-md-4">
                    <label for="l_name" class="form-label">นามสกุล *</label>
                    <input type="text" name="l_name" id="l_name" class="form-control"
                        value="{{ old('l_name', $software->l_name) }}" placeholder="นามสกุล" required readonly>
                </div>

                <!-- Department -->
                <div class="col-md-4">
                    <label for="department_id" class="form-label">
                        แผนก <span class="text-danger">*</span>
                    </label>
                    <select name="department_id" id="department_id" class="form-control" required
                        style="pointer-events: none">
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

            <!-- Contact and Date -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tel" class="form-label">เบอร์โทรติดต่อกลับ *</label>
                    <input type="text" name="tel" id="tel" class="form-control"
                        value="{{ old('tel', $software->tel) }}" placeholder="เบอร์โทรติดต่อกลับ" required>
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">วันที่ขอ *</label>
                    <input type="date" name="date" id="date" class="form-control"
                        value="{{ old('date', $software->date) }}" required readonly>
                </div>
            </div>

            <!-- Software Name -->
            <div class="mb-3">
                <label for="software_name" class="form-label">ชื่อระบบ *</label>
                <input type="text" name="software_name" id="software_name" class="form-control" placeholder="ชื่อระบบ"
                    value="{{ old('software_name', $software->software_name) }}" required>
            </div>

            <!-- Problem -->
            <div class="mb-3">
                <label for="problem" class="form-label">ปัญหาที่เกิดขึ้นจากระบบเดิม *</label>
                <textarea name="problem" id="problem" rows="3" class="form-control" placeholder="ปัญหาที่เกิดขึ้นจากระบบเดิม"
                    required>{{ old('problem', $software->problem) }}</textarea>
            </div>

            <!-- Purpose -->
            <div class="mb-3">
                <label for="purpose" class="form-label">วัตถุประสงค์การพัฒนาระบบใหม่ *</label>
                <textarea name="purpose" id="purpose" rows="3" class="form-control" placeholder="วัตถุประสงค์การพัฒนาระบบใหม่"
                    required>{{ old('purpose', $software->purpose) }}</textarea>
            </div>

            <!-- Target -->
            <div class="mb-3">
                <label for="target" class="form-label">กลุ่มเป้าหมายการใช้งาน *</label>
                <textarea name="target" id="target" rows="2" class="form-control" placeholder="กลุ่มเป้าหมายการใช้งาน"
                    required>{{ old('target', $software->target) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('softwares.show', $software->software_id) }}" class="btn btn-danger me-2">ยกเลิก</a>
                <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
            </div>
        </form>
    </div>
@endsection

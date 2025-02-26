@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-4">แก้ไขรายละเอียดการดำเนินงาน</h4>

    <form action="{{ route('timelines.update', $timeline->timeline_id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="timeline_date" class="form-label">วัน/เดือน/ปี *</label>
            <input type="date" name="timeline_date" class="form-control" value="{{ $timeline->timeline_date }}" required>
        </div>

        <div class="mb-3">
            <label for="timeline_step" class="form-label">รายละเอียดการพัฒนา *</label>
            <select name="timeline_step" id="timeline_step" class="form-control" required>
                <option value="Design โปรแกรม" {{ $timeline->timeline_step == 'Design โปรแกรม' ? 'selected' : '' }}>Design โปรแกรม</option>
                <option value="พัฒนาโปรแกรม" {{ $timeline->timeline_step == 'พัฒนาโปรแกรม' ? 'selected' : '' }}>พัฒนาโปรแกรม</option>
                <option value="ทดสอบระบบ" {{ $timeline->timeline_step == 'ทดสอบระบบ' ? 'selected' : '' }}>ทดสอบระบบ</option>
                <option value="Complete" {{ $timeline->timeline_step == 'Complete' ? 'selected' : '' }}>Complete</option>
                <option value="Other" {{ $timeline->timeline_step == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="mb-3" id="otherStepInput" style="display: none;">
            <label for="other_timeline_step" class="form-label">รายละเอียดเพิ่มเติม *</label>
            <textarea name="other_timeline_step" id="other_timeline_step" class="form-control" rows="3" placeholder="กรอกรายละเอียดเพิ่มเติม"></textarea>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success me-2">บันทึก</button>
            <a href="{{ route('timelines.edit', $timeline->timeline_regist_number) }}" class="btn btn-danger">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        document.getElementById('timeline_step').addEventListener('change', function() {
            const otherStepInput = document.getElementById('otherStepInput');
            const otherTimelineStep = document.getElementById('other_timeline_step');

            if (this.value === 'Other') {
                otherStepInput.style.display = 'block';
                otherTimelineStep.setAttribute('required', 'required');
            } else {
                otherStepInput.style.display = 'none';
                otherTimelineStep.removeAttribute('required');
            }
        });
    </script>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container p-3 border border-dark border-2 rounded-3  ">
        <h4 class="fw-bold mb-4">สถานะการดำเนินงาน</h4>

        <!-- Tabs -->
        <ul class="nav nav-pills mb-3" id="timelineTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="pill" data-bs-target="#details-content"
                    type="button" role="tab" aria-controls="details-content" aria-selected="true">
                    เพิ่มรายละเอียดการดำเนินงาน
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="duration-tab" data-bs-toggle="pill" data-bs-target="#duration-content"
                    type="button" role="tab" aria-controls="duration-content" aria-selected="false">
                    ระยะเวลาพัฒนา
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Add Timeline Details -->
            <div class="tab-pane fade show active" id="details-content" role="tabpanel" aria-labelledby="details-tab">
                <table class="table table-bordered mb-4">
                    <thead class="table-light">
                        <tr>
                            <th>วัน/เดือน/ปี</th>
                            <th>รายละเอียดการพัฒนา</th>
                            <th>ผู้บันทึก</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($timelines as $timeline)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($timeline->timeline_date)->format('d F Y') }}</td>
                                <td>{{ $timeline->timeline_step }}</td>
                                <td>{{ $timeline->recorded_by ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('timelines.editTimeline', $timeline->timeline_id) }}"
                                        class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('timelines.destroy', $timeline->timeline_id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Add New Timeline Form -->
                <form action="{{ route('timelines.store', $software->software_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="timeline_date" class="form-label">วัน/เดือน/ปี *</label>
                        <input type="date" name="timeline_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="timeline_step" class="form-label">รายละเอียดการพัฒนา *</label>
                        <select name="timeline_step" id="timeline_step" class="form-control" required>
                            <option value="" disabled selected>เลือกขั้นตอน</option>
                            <option value="Design โปรแกรม">Design โปรแกรม</option>
                            <option value="พัฒนาโปรแกรม">พัฒนาโปรแกรม</option>
                            <option value="ทดสอบระบบ">ทดสอบระบบ</option>
                            <option value="Complete">Complete</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3" id="otherStepInput" style="display: none;">
                        <label for="other_timeline_step" class="form-label">รายละเอียดเพิ่มเติม *</label>
                        <textarea name="other_timeline_step" id="other_timeline_step" class="form-control" rows="3"
                            placeholder="กรอกรายละเอียดเพิ่มเติม"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">เพิ่ม</button>
                        <a href="{{ route('softwares.list') }}" class="btn btn-danger">ปิด</a>
                    </div>
                </form>
            </div>

            <!-- Set Development Duration -->
            <div class="tab-pane fade" id="duration-content" role="tabpanel" aria-labelledby="duration-tab">
                <form action="{{ route('softwares.updateDuration', $software->software_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="timeline_start" class="form-label">วันเริ่มต้นพัฒนา *</label>
                            <input type="date" name="timeline_start" id="timeline_start" class="form-control"
                                value="{{ old('timeline_start', optional($software->timeline_start)->format('Y-m-d')) }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="timeline_end" class="form-label">วันสิ้นสุดการพัฒนา *</label>
                            <input type="date" name="timeline_end" id="timeline_end" class="form-control"
                                value="{{ old('timeline_end', optional($software->timeline_end)->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">บันทึก</button>
                        <a href="{{ route('softwares.adminApprovals') }}" class="btn btn-danger">ปิด</a>
                    </div>
                </form>
            </div>
        </div>
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

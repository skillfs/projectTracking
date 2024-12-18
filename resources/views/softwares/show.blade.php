@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">รายละเอียดข้อมูลการพัฒนาซอฟต์แวร์</h4>
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">
            &larr; กลับ
        </button>
    </div>

    <!-- Software Details Section -->
    <div class="row">
        <!-- Left Column: Main Details -->
        <div class="col-lg-9">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Row 1: Registration No., Software Name -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>เลขลงทะเบียน:</strong><br>
                            {{ $software->software_id }}
                        </div>
                        <div class="col-md-4">
                            <strong>ชื่อระบบ:</strong><br>
                            {{ $software->software_name }}
                        </div>
                        <div class="col-md-4">
                            <strong>วันที่ขอ:</strong><br>
                            {{ \Carbon\Carbon::parse($software->date)->format('d F Y') }}
                        </div>
                    </div>

                    <!-- Row 2: Requester Name, Department, Tel -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>ชื่อผู้ขอ:</strong><br>
                            {{ $software->f_name }} {{ $software->l_name }}
                        </div>
                        <div class="col-md-4">
                            <strong>แผนก:</strong><br>
                            {{ $software->department->department_name ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>เบอร์โทรศัพท์:</strong><br>
                            {{ $software->tel }}
                        </div>
                    </div>

                    <!-- Problem -->
                    <div class="mb-3">
                        <strong>ปัญหาที่เกิดขึ้นจากระบบเดิม:</strong><br>
                        {{ $software->problem ?? '-' }}
                    </div>

                    <!-- Purpose -->
                    <div class="mb-3">
                        <strong>วัตถุประสงค์ที่ต้องการพัฒนาระบบใหม่:</strong><br>
                        {{ $software->purpose ?? '-' }}
                    </div>

                    <!-- Target -->
                    <div class="mb-3">
                        <strong>กลุ่มเป้าหมายการใช้งาน:</strong><br>
                        {{ $software->target ?? '-' }}
                    </div>

                    <!-- File -->
                    <div class="mb-3">
                        <strong>ไฟล์แนบ:</strong><br>
                        @if($software->file)
                        <a href="{{ asset('storage/' . $software->file) }}" target="_blank">ดาวน์โหลดไฟล์แนบ</a>
                        @else
                        ไม่มีไฟล์แนบ
                        @endif
                    </div>

                    <!-- Status Steps -->
                    <div class="mb-3">
                        <strong>ขั้นตอน:</strong><br>
                        <div class="d-flex align-items-center justify-content-around mt-3">
                            <!-- Example steps: adjust logic & styling as needed -->
                            <div class="text-center">
                                <i class="bi bi-x-circle {{ $software->status === 'canceled' ? 'text-danger' : 'text-muted' }}"></i><br>
                                ยกเลิก
                            </div>
                            <div class="text-center">
                                <i class="bi bi-person-check {{ $software->status === 'approved by DH' || $software->approved_by_dh ? 'text-primary' : 'text-muted' }}"></i><br>
                                หัวหน้าแผนก
                            </div>
                            <div class="text-center">
                                <i class="bi bi-person-badge {{ $software->status === 'approved by admin' || $software->approved_by_admin ? 'text-primary' : 'text-muted' }}"></i><br>
                                หัวหน้าทีมพัฒนา
                            </div>
                            <div class="text-center">
                                <i class="bi bi-hourglass-split {{ $software->status === 'queued' ? 'text-primary' : 'text-muted' }}"></i><br>
                                รอคิว
                            </div>
                            <div class="text-center">
                                <i class="bi bi-tools {{ $software->status === 'in progress' ? 'text-primary' : 'text-muted' }}"></i><br>
                                กำลังพัฒนา
                            </div>
                            <div class="text-center">
                                <i class="bi bi-check-circle {{ $software->status === 'completed' ? 'text-success' : 'text-muted' }}"></i><br>
                                เสร็จ
                            </div>
                        </div>
                    </div>

                    <!-- Development Timeframe -->
                    <div class="mb-3">
                        <strong>ระยะเวลาพัฒนา:</strong><br>
                        <!-- Replace with logic to determine start and end from timeline or separate fields -->
                        เริ่มต้น 1 สิงหาคม 2567 ถึงวันที่ 31 ตุลาคม 2567
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Timeline -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    ไทม์ไลน์การดำเนินงาน
                </div>
                <div class="card-body">
                    @if($software->timelines && $software->timelines->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($software->timelines as $timeline)
                        <li class="mb-3">
                            <div class="fw-bold">
                                {{ \Carbon\Carbon::parse($timeline->timeline_date)->format('d F Y') }}
                            </div>
                            <div>{{ $timeline->timeline_step }}</div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center text-muted">ยังไม่มีข้อมูล</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('softwares.edit', $software->software_id) }}" class="btn btn-warning me-2">แก้ไข</a>
        <!-- "ลบ" Button triggers the modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            ลบ
        </button>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; padding: 20px;">
            <div class="modal-body text-center">
                <h5 class="mb-4">คุณยืนยันที่จะลบหรือไม่</h5>
                <div class="d-flex justify-content-center gap-3">
                    <!-- Close button for modal -->
                    <button type="button" class="btn" style="background-color: #ffcccc; color: #b30000;" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <!-- Confirm delete button triggers form submission -->
                    <form action="{{ route('softwares.destroy', $software->software_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #ccffcc; color: #009900;">
                            ตกลง
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
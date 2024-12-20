@extends('layouts.app')

@section('content')
@php
$user = Auth::user();
$userRole = $user->role()->first() ? $user->role()->first()->role_name : '';

// Conditions for displaying buttons
// For normal user: can edit if they are the owner of the request,
// the status is 'pending', and not approved by DH.
$canEdit = ($userRole !== 'Admin' && $userRole !== 'Department Head')
&& ($software->status === 'pending' && !$software->approved_by_dh)
&& ($software->f_name === $user->f_name && $software->l_name === $user->l_name);
@endphp

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">รายละเอียดข้อมูลการพัฒนาซอฟต์แวร์</h4>
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">
            &larr; กลับ
        </button>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Software details -->
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

                    <div class="mb-3">
                        <strong>ปัญหาที่เกิดขึ้นจากระบบเดิม:</strong><br>
                        {{ $software->problem ?? '-' }}
                    </div>

                    <div class="mb-3">
                        <strong>วัตถุประสงค์ที่ต้องการพัฒนาระบบใหม่:</strong><br>
                        {{ $software->purpose ?? '-' }}
                    </div>

                    <div class="mb-3">
                        <strong>กลุ่มเป้าหมายการใช้งาน:</strong><br>
                        {{ $software->target ?? '-' }}
                    </div>

                    <div class="mb-3">
                        <strong>ไฟล์แนบ:</strong><br>
                        @if($software->file)
                        <a href="{{ asset('storage/' . $software->file) }}" target="_blank">ดาวน์โหลดไฟล์แนบ</a>
                        @else
                        ไม่มีไฟล์แนบ
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>สถานะปัจจุบัน:</strong> {{ $software->status }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Column -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-dark text-white">ไทม์ไลน์การดำเนินงาน</div>
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

    <!-- Action Buttons based on Role and Status -->
    <div class="d-flex justify-content-end mt-4">
        @if($userRole === 'Department Head')
        @if($software->status === 'pending')
        <!-- DH Approve/Reject -->
        <form action="{{ route('softwares.update', $software->software_id) }}" method="POST" class="me-2">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="approved by DH">
            <button type="submit" class="btn btn-success">อนุมัติ</button>
        </form>
        <form action="{{ route('softwares.update', $software->software_id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="canceled">
            <button type="submit" class="btn btn-danger">ปฏิเสธ</button>
        </form>
        @endif
        @elseif($userRole === 'Admin')
        @if($software->approved_by_dh && $software->status === 'approved by DH')
        <!-- Admin Approve/Reject -->
        <form action="{{ route('softwares.update', $software->software_id) }}" method="POST" class="me-2">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="approved by admin">
            <button type="submit" class="btn btn-success">อนุมัติ</button>
        </form>
        <form action="{{ route('softwares.update', $software->software_id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="canceled">
            <button type="submit" class="btn btn-danger">ปฏิเสธ</button>
        </form>
        @elseif($software->approved_by_admin)
        <!-- After admin has approved, show Edit button instead -->
        <a href="{{ route('softwares.edit', $software->software_id) }}" class="btn btn-warning me-2">แก้ไข</a>
        @endif
        @elseif($canEdit)
        <!-- Normal User Edit/Delete if pending and not approved by DH and is their own request -->
        <a href="{{ route('softwares.edit', $software->software_id) }}" class="btn btn-warning me-2">แก้ไข</a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            ลบ
        </button>
        @endif
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
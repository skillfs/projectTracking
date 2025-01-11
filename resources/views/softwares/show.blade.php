@extends('layouts.app')

@section('content')

    @php
        $user = Auth::user();
        $userRole = $user->role()->first() ? $user->role()->first()->role_name : '';

        // For normal user: can edit if they are the owner of the request,
        // the status is 'pending', and not approved by DH.
        $canEdit =
            $userRole !== 'Admin' &&
            $userRole !== 'Department Head' &&
            $software->status === 'pending' &&
            !$software->approved_by_dh &&
            $software->f_name === $user->f_name &&
            $software->l_name === $user->l_name;
    @endphp

    <div class="container">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">รายละเอียดข้อมูลการพัฒนาซอฟต์แวร์</h4>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                &larr; กลับ
            </button>
        </div>

        {{-- Main Content Row --}}
        <div class="row">
            {{-- Software Details --}}
            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-body">
                        {{-- Row 1 --}}
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

                        {{-- Row 2 --}}
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

                        {{-- Attached Files --}}
                        @php
                            $files = $software->file ? json_decode($software->file, true) : [];
                        @endphp
                        <div class="mb-3">
                            <strong>ไฟล์แนบ:</strong>
                            <ul>
                                @if ($uploadedFiles->count() > 0)
                                    @foreach ($uploadedFiles as $file)
                                        <li>
                                            <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                                                {{ $file->original_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-muted">ไม่มีไฟล์แนบ</li>
                                @endif
                            </ul>
                        </div>
                        <style>
                            .status {
                                display: flex;
                            }
                        </style>
                        {{-- Current Status --}}
                        <div class="mb-3">
                            <strong>สถานะ :</strong>
                            <div class="status">
                                @php
                                    $statuses = [
                                        'canceled' => 'image/cancel',
                                        'pending' => 'image/person',
                                        'approved by DH' => 'image/person',
                                        'queued' => 'image/wait',
                                        'in progress' => 'image/dev',
                                        'finish' => 'image/finish',
                                    ];
                                    $currentStatusFound = false;
                                @endphp

                                @foreach ($statuses as $statusKey => $imagePath)
                                    @php
                                        $isActive =
                                            !$currentStatusFound &&
                                            !($software->status === 'approved by DH' && $statusKey === 'canceled');

                                        if ($software->status === $statusKey) {
                                            $currentStatusFound = true;
                                        }
                                    @endphp

                                    <div style="text-align: center; margin-bottom: 10px;">
                                        @if (!($software->status === 'canceled') && $statusKey === 'canceled')
                                            <img src="{{ url('image/cancel_inactive.png') }}" alt="{{ $statusKey }}"
                                                width="35" height="35">
                                        @else
                                            <img src="{{ url($isActive ? $imagePath . '_active.png' : $imagePath . '_inactive.png') }}"
                                                alt="{{ $statusKey }}" width="35" height="35">
                                        @endif

                                        {{-- แสดงชื่อสถานะ --}}
                                        <p style="margin-top: 5px;">{{ $statusKey }}</p>
                                    </div>

                                    @if (!$loop->last)
                                        @php
                                            if ($software->status === 'canceled') {
                                                $lineImage = $loop->first
                                                    ? 'image/line_cancel.png'
                                                    : 'image/line_inactive.png';
                                            } else {
                                                if ($loop->first) {
                                                    $lineImage = 'image/line_inactive.png';
                                                } else {
                                                    $lineImage = !$currentStatusFound
                                                        ? 'image/line_active.png'
                                                        : 'image/line_inactive.png';
                                                }
                                            }
                                        @endphp
                                        <img src="{{ url($lineImage) }}" alt="line" width="80" height="35">
                                    @endif
                                @endforeach
                            </div>

                        </div>

                        {{-- Development Timeline --}}
                        <div class="mb-3">
                            <strong>ระยะเวลาพัฒนา:</strong><br>
                            @if ($software->timeline_start && $software->timeline_end)
                                เริ่มวันที่ {{ \Carbon\Carbon::parse($software->timeline_start)->format('d F Y') }}
                                ถึง {{ \Carbon\Carbon::parse($software->timeline_end)->format('d F Y') }}
                            @else
                                <span class="text-muted">ยังไม่ได้กำหนดระยะเวลาพัฒนา</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline Column --}}
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-dark text-white">ไทม์ไลน์การดำเนินงาน</div>
                    <div class="card-body">
                        @if ($timelines->count() > 0)
                            <ul class="list-unstyled">
                                @foreach ($timelines as $timeline)
                                    <li class="mb-3">
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($timeline->timeline_date)->format('d M Y') }}
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

        {{-- Action Buttons based on Role and Status --}}
        <div class="d-flex justify-content-end mt-4">
            @if ($userRole === 'Department Head')
                @if ($software->status === 'pending')
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
                @if ($software->approved_by_dh && $software->status === 'approved by DH')
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
                @elseif($software->approved_by_admin || $software->status === 'queued' || $software->status === 'in progress')
                    <a href="{{ route('timelines.edit', $software->software_id) }}" class="btn btn-warning me-2">แก้ไข</a>
                @endif
            @elseif($canEdit)
                <!-- Normal User Edit/Delete if pending/not approved by DH -->
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
                        <button type="button" class="btn" style="background-color: #ffcccc; color: #b30000;"
                            data-bs-dismiss="modal">
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

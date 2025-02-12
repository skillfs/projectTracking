@extends('layouts.app')

@section('content')
    @php
        $user = Auth::user();
        $userRole = $user && $user->role()->first() ? $user->role()->first()->role_name : '';
        $routeName = request()->route()->getName();
    @endphp
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>คำขอพัฒนาซอฟต์แวร์</h2>
            <a href="{{ route('softwares.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> เพิ่มคำขอ
            </a>
        </div>

        <!-- Table Section -->
        <table id="software_table" class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>วันที่ขอ</th>
                    <th>ชื่อระบบ</th>
                    <th>ผู้ขอ</th>
                    <th>สถานะคำขอ</th>
                    <th>รายละเอียด</th>
                    @if (
                        ($routeName === 'softwares.dhApprovals' && $userRole === 'department_head') ||
                            ($routeName === 'softwares.adminApprovals' && $userRole === 'admin'))
                        <th>ดำเนินการ</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($softwares as $software)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($software->date)->format('Y F d') }}</td>
                        <td>{{ $software->software_name }}</td>
                        <td>{{ $software->f_name }} {{ $software->l_name }}</td>
                        <td>@php
                            $badgeClasses = [
                                'canceled' => 'bg-danger p-2',
                                'completed' => 'bg-success p-2',
                                'queued' => 'bg-info p-2',
                                'pending' => 'bg-warning p-2',
                                'approved by DH' => 'bg-warning p-2',
                                'in progress' => 'bg-primary p-2',
                            ];
                        @endphp
                            <span class="badge {{ $badgeClasses[$software->status] ?? 'bg-secondary p-2' }}">
                                @switch($software->status)
                                    @case('canceled')
                                        ยกเลิก
                                    @break

                                    @case('completed')
                                        เสร็จสิ้น
                                    @break

                                    @case('queued')
                                        อยู่ในคิว
                                    @break

                                    @case('pending')
                                        รอหัวหน้าแผนกอนุมัติ
                                    @break

                                    @case('approved by DH')
                                        รอหัวหน้าทีมพัฒนาอนุมัติ
                                    @break

                                    @case('in progress')
                                        กำลังดำเนินการ
                                    @break

                                    @default
                                        ไม่ทราบสถานะ
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('softwares.show', $software->software_id) }}" class="btn btn-info btn-sm">
                                แสดงรายละเอียดคำขอ
                            </a>
                        </td>
                        @if ($routeName === 'softwares.dhApprovals' && $userRole === 'department_head')
                            <!-- For DH: Approve/Reject pending requests -->
                            <!-- Only show if status is pending, or whatever condition you use for DH approvals -->
                            @if ($software->status === 'pending')
                                <td>
                                    <form action="{{ route('softwares.updateStatus', $software->software_id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved by DH">
                                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                                    </form>
                                    <form action="{{ route('softwares.updateStatus', $software->software_id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">
                                        <button type="submit" class="btn btn-danger btn-sm">ปฏิเสธ</button>
                                    </form>
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @elseif($routeName === 'softwares.adminApprovals' && $userRole === 'admin')
                            @if ($software->status === 'approved by DH')
                                <!-- admin Approve/Reject -->
                                <td>
                                    <form action="{{ route('softwares.updateStatus', $software->software_id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="queued">
                                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                                    </form>

                                    <form action="{{ route('softwares.updateStatus', $software->software_id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">
                                        <button type="submit" class="btn btn-danger btn-sm">ปฏิเสธ</button>
                                    </form>
                                </td>
                            @elseif($software->status === 'queued' || $software->status === 'in progress')
                                <!-- admin can now edit these requests -->
                                <td>
                                    <a href="{{ route('timelines.edit', $software->software_id) }}"
                                        class="btn btn-warning btn-sm">แก้ไข</a>
                                </td>
                            @else
                                <!-- For other statuses that appear here, no action available -->
                                <td>-</td>
                            @endif
                        @endif
                    </tr>
                    @empty
                        <tr>
                            <td colspan="{{ ($routeName === 'softwares.dhApprovals' && $userRole === 'department_head') || ($routeName === 'softwares.adminApprovals' && $userRole === 'admin') ? '6' : '5' }}"
                                class="text-center">ไม่มีข้อมูลคำขอ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#software_table').DataTable();
            })
        </script>
    @endsection

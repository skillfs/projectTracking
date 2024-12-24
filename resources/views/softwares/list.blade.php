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

    <!-- Removed the Filter Section -->

    <!-- Table Section -->
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>วันที่ขอ</th>
                <th>ชื่อระบบ</th>
                <th>ผู้ขอ</th>
                <th>สถานะคำขอ</th>
                <th>รายละเอียด</th>
                @if(($routeName === 'softwares.dhApprovals' && $userRole === 'Department Head') ||
                ($routeName === 'softwares.adminApprovals' && $userRole === 'Admin'))
                <th>ดำเนินการ</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($softwares as $software)
            <tr>
                <td>{{ \Carbon\Carbon::parse($software->date)->format('d F Y') }}</td>
                <td>{{ $software->software_name }}</td>
                <td>{{ $software->f_name }} {{ $software->l_name }}</td>
                <td>{{ $software->status }}</td>
                <td>
                    <a href="{{ route('softwares.show', $software->software_id) }}" class="btn btn-info btn-sm">
                        แสดงรายละเอียดคำขอ
                    </a>
                </td>
                @if($routeName === 'softwares.dhApprovals' && $userRole === 'Department Head')
                <!-- For DH: Approve/Reject pending requests -->
                <!-- Only show if status is pending, or whatever condition you use for DH approvals -->
                @if($software->status === 'pending')
                <td>
                    <form action="{{ route('softwares.update', $software->software_id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved by DH">
                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                    </form>

                    <form action="{{ route('softwares.update', $software->software_id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="canceled">
                        <button type="submit" class="btn btn-danger btn-sm">ปฏิเสธ</button>
                    </form>
                </td>
                @else
                <td>-</td>
                @endif
                @elseif($routeName === 'softwares.adminApprovals' && $userRole === 'Admin')
                @if($software->status === 'approved by DH')
                <!-- Admin Approve/Reject -->
                <td>
                    <form action="{{ route('softwares.update', $software->software_id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved by admin">
                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                    </form>

                    <form action="{{ route('softwares.update', $software->software_id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="canceled">
                        <button type="submit" class="btn btn-danger btn-sm">ปฏิเสธ</button>
                    </form>
                </td>
                @elseif($software->status === 'queued' || $software->status === 'in progress')
                <!-- Admin can now edit these requests -->
                <td>
                    <a href="{{ route('timelines.edit', $software->software_id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                </td>
                @else
                <!-- For other statuses that appear here, no action available -->
                <td>-</td>
                @endif
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ ($routeName === 'softwares.dhApprovals' && $userRole === 'Department Head') || ($routeName === 'softwares.adminApprovals' && $userRole === 'Admin') ? '6' : '5' }}" class="text-center">ไม่มีข้อมูลคำขอ</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
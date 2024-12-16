@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>คำขอพัฒนาซอฟต์แวร์</h2>
        <a href="{{ route('softwares.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> เพิ่มคำขอ
        </a>
    </div>

    <!-- Filter Section -->
    <div class="d-flex mb-3">
        <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="filter" id="all" checked>
            <label class="form-check-label" for="all">ทั้งหมด</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="filter" id="myRequests">
            <label class="form-check-label" for="myRequests">เฉพาะคำขอของฉัน</label>
        </div>
    </div>

    <!-- Table Section -->
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>วันที่ขอ</th>
                <th>ชื่อระบบ</th>
                <th>ผู้ขอ</th>
                <th>สถานะคำขอ</th>
                <th>รายละเอียด</th>
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
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">ไม่มีข้อมูลคำขอ</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
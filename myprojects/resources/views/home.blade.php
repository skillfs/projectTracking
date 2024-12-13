@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">งานพัฒนาซอฟต์แวร์</a>
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="#">หน้าแรก</a>
                <a class="nav-link" href="#">คำขอพัฒนา</a>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-bell fs-4 text-white me-3"></i>
                <div class="rounded-circle bg-white" style="width: 40px; height: 40px;"></div>
            </div>
        </div>
    </nav>

    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">คำขอทั้งหมด</h5>
                    <p class="card-text fs-4">{{ $software->count() }}</p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">รอหัวหน้าแผนก</h5>
                    <p class="card-text fs-4">{{ $software->where('status', 'pending')->count() }}</p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">รอหัวหน้าทีมพัฒนา</h5>
                    <p class="card-text fs-4">{{ $software->where('status', 'approved by DH')->count() }}</p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">รอคิวพัฒนา</h5>
                    <p class="card-text fs-4">{{ $software->where('status', 'queued')->count() }}</p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">กำลังพัฒนา</h5>
                    <p class="card-text fs-4">{{ $software->where('status', 'in progress')->count() }}</p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">พัฒนาเสร็จสิ้น</h5>
                    <p class="card-text fs-4">{{ $software->where('status', 'completed')->count() }}</p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        @foreach(['pending' => 'รอหัวหน้าแผนก', 'approved by DH' => 'รอหัวหน้าทีมพัฒนา', 'queued' => 'รอคิวพัฒนา', 'in progress' => 'กำลังพัฒนา', 'completed' => 'พัฒนาเสร็จสิ้น', 'canceled' => 'ยกเลิก'] as $status => $label)
        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    {{ $label }} {{ $software->where('status', $status)->count() }} รายการ
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อระบบ</th>
                                <th>การกระทำ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($software->where('status', $status) as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->software_name }}</td>
                                <td>
                                    @if(Auth::user()->status === 'Department Head' && $item->status === 'pending')
                                    <form method="POST" action="{{ route('softwares.approveByDH', $item) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                                    </form>
                                    @elseif(Auth::user()->status === 'Admin' && $item->status === 'approved by DH')
                                    <form method="POST" action="{{ route('softwares.approveByAdmin', $item) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">อนุมัติ</button>
                                    </form>
                                    @else
                                    <span class="text-muted">ไม่มีการกระทำ</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($software->where('status', $status)->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
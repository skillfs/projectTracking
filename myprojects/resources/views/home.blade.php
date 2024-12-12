@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Check if $software is available -->
    @php
    $software = $software ?? collect(); // Ensure $software is always defined as a collection
    @endphp

    <!-- Summary Cards (Red Circle) -->
    <div class="row text-center mb-4">
        @if(Auth::check())
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">คำขอทั้งหมด</h5>
                    <p class="card-text fs-4">
                        @if(Auth::user()->status === 'Admin')
                        {{ $software->count() }}
                        @elseif(Auth::user()->status === 'Department Head')
                        {{ $software->where('department_id', Auth::user()->department_id)->count() }}
                        @else
                        {{ $software->where('f_name', Auth::user()->f_name)->where('l_name', Auth::user()->l_name)->count() }}
                        @endif
                    </p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        @foreach(['queued', 'in progress', 'canceled', 'completed'] as $status)
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($status) }}</h5>
                    <p class="card-text fs-4">
                        @if(Auth::user()->status === 'Admin')
                        {{ $software->where('status', $status)->count() }}
                        @elseif(Auth::user()->status === 'Department Head')
                        {{ $software->where('status', $status)->where('department_id', Auth::user()->department_id)->count() }}
                        @else
                        {{ $software->where('status', $status)->where('f_name', Auth::user()->f_name)->where('l_name', Auth::user()->l_name)->count() }}
                        @endif
                    </p>
                    <p class="card-text">รายการ</p>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Guest Access</h5>
                    <p class="card-text">Please log in to see your software requests.</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- List Tables (Blue Circle) -->
    @if(Auth::check())
    <div class="row">
        @foreach(['queued' => 'รอคิว', 'in progress' => 'กำลังพัฒนา', 'canceled' => 'ยกเลิก', 'completed' => 'พัฒนาเสร็จสิ้น'] as $status => $label)
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    {{ $label }}
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อระบบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $filteredSoftware = [];
                            if (Auth::user()->status === 'Admin') {
                            $filteredSoftware = $software->where('status', $status);
                            } elseif (Auth::user()->status === 'Department Head') {
                            $filteredSoftware = $software->where('status', $status)->where('department_id', Auth::user()->department_id);
                            } else {
                            $filteredSoftware = $software->where('status', $status)->where('f_name', Auth::user()->f_name)->where('l_name', Auth::user()->l_name);
                            }
                            @endphp
                            @foreach($filteredSoftware as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->software_name }}</td>
                            </tr>
                            @endforeach
                            @if(empty($filteredSoftware))
                            <tr>
                                <td colspan="2" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection